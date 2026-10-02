<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\SmsLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    /**
     * Display the interactive Teacher Dashboard with section presence overview and student attendance list.
     */
    public function index(Request $request)
    {
        $data = $this->getDashboardData($request);

        return view('teacher.dashboard', $data);
    }

    /**
     * API endpoint for real-time live synchronization (polling without page refresh).
     */
    public function liveData(Request $request)
    {
        $data = $this->getDashboardData($request);

        // Format student collection for lightweight JSON response
        $studentsData = $data['students']->map(function ($s) {
            $att = $s->attendance_record;
            return [
                'id' => $s->id,
                'student_no' => $s->student_no,
                'name' => $s->formatted_name,
                'first_name' => $s->first_name,
                'last_name' => $s->last_name,
                'photo_url' => $s->photo_url,
                'grade_level' => $s->grade_level,
                'section' => $s->section,
                'time_in' => $att && $att->time_in ? Carbon::parse($att->time_in)->format('h:i A') : '—',
                'time_out' => $att && $att->time_out ? Carbon::parse($att->time_out)->format('h:i A') : '—',
                'presence_status' => $s->presence_status,
                'status' => $att?->status ?: 'Absent',
                'remarks' => $att?->remarks ?: '',
                'parent_contact_info' => $s->parent_contact_info,
            ];
        });

        return response()->json([
            'success' => true,
            'totalStudents' => $data['totalStudents'],
            'presentToday' => $data['presentToday'],
            'insideCampus' => $data['insideCampus'],
            'departedToday' => $data['departedToday'],
            'lateToday' => $data['lateToday'],
            'absentToday' => $data['absentToday'],
            'excusedToday' => $data['excusedToday'],
            'presenceRate' => $data['presenceRate'],
            'students' => $studentsData,
        ]);
    }

    /**
     * Helper method to compute dashboard data.
     */
    private function getDashboardData(Request $request): array
    {
        $user = auth()->user();
        $teacher = $user->role === 'teacher' ? $user->teacher : null;
        $assignedSections = $teacher ? $teacher->assigned_sections : [];

        $selectedDate = $request->input('date', Carbon::now('Asia/Manila')->toDateString());
        $requestedSection = $request->input('section', '');
        $selectedGrade = $request->input('grade_level', '');
        $search = trim($request->input('search', ''));

        // Sections filter options for dropdown: strictly limit to assigned sections for teachers
        if ($user->role === 'teacher') {
            $sections = collect($assignedSections)->sort()->values();
        } else {
            $sections = Student::distinct()->whereNotNull('section')->where('section', '!=', '')->pluck('section')->sort()->values();
        }

        // Validate and determine active section filter
        $selectedSection = '';
        if ($requestedSection && (in_array($requestedSection, $assignedSections) || $user->role !== 'teacher')) {
            $selectedSection = $requestedSection;
        } elseif (count($assignedSections) === 1) {
            $selectedSection = $assignedSections[0];
        }

        // Grade levels for dropdown filters based on assigned cohort
        if ($user->role === 'teacher') {
            $gradeLevels = empty($assignedSections)
                ? collect()
                : Student::whereIn('section', $assignedSections)->whereNotNull('grade_level')->where('grade_level', '!=', '')->pluck('grade_level')->unique()->sort()->values();
        } else {
            $gradeLevels = Student::distinct()->whereNotNull('grade_level')->where('grade_level', '!=', '')->pluck('grade_level')->sort()->values();
        }

        // Query active students belonging ONLY to the teacher's assigned section(s)
        $studentQuery = Student::with(['parents.user'])->where('status', 'Active');

        if ($user->role === 'teacher') {
            if (empty($assignedSections)) {
                $studentQuery->whereRaw('1 = 0');
            } elseif ($selectedSection) {
                $studentQuery->where('section', $selectedSection);
            } else {
                $studentQuery->whereIn('section', $assignedSections);
            }
        } else {
            if ($selectedSection) {
                $studentQuery->where('section', $selectedSection);
            }
        }

        if ($selectedGrade) {
            $studentQuery->where('grade_level', $selectedGrade);
        }

        if ($search) {
            $studentQuery->where(function ($q) use ($search) {
                $q->where('student_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        $students = $studentQuery->orderBy('last_name')->orderBy('first_name')->get();

        // Get attendances for selected date
        $attendances = Attendance::with('student', 'guardProfile')
            ->whereDate('attendance_date', $selectedDate)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        // Calculate KPI Metrics for this cohort & date
        $totalStudents = $students->count();
        $insideCampus = 0;
        $departedToday = 0;
        $presentToday = 0;
        $lateToday = 0;
        $absentToday = 0;
        $excusedToday = 0;

        foreach ($students as $student) {
            $att = $attendances->get($student->id);
            $student->attendance_record = $att;

            // Format parent contact info
            $parent = $student->parents->first();
            if ($parent) {
                $pName = trim("{$parent->first_name} {$parent->last_name}");
                $pPhone = $parent->phone ?: ($parent->user?->email ?: 'No Phone');
                $student->parent_contact_info = "{$pName} ({$pPhone})";
            } else {
                $student->parent_contact_info = 'No Parent Linked';
            }

            if ($att) {
                if ($att->status === 'Excused') {
                    $student->presence_status = 'Excused';
                    $excusedToday++;
                } elseif ($att->status === 'Absent') {
                    $student->presence_status = 'Absent';
                    $absentToday++;
                } elseif ($att->time_in && !$att->time_out) {
                    $student->presence_status = 'Inside Campus';
                    $insideCampus++;
                    $presentToday++;
                    if ($att->status === 'Late') {
                        $lateToday++;
                    }
                } elseif ($att->time_in && $att->time_out) {
                    $student->presence_status = 'Departed';
                    $departedToday++;
                    $presentToday++;
                    if ($att->status === 'Late') {
                        $lateToday++;
                    }
                } else {
                    $student->presence_status = $att->status ?: 'Present';
                    $presentToday++;
                    if ($att->status === 'Late') {
                        $lateToday++;
                    }
                }
            } else {
                $student->presence_status = 'Absent';
                $absentToday++;
            }
        }

        $presenceRate = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100) : 0;

        // Recent live gate scans for the live feed widget strictly scoped to assigned section(s)
        $recentScansQuery = Attendance::with('student')
            ->whereDate('attendance_date', $selectedDate);

        if ($user->role === 'teacher') {
            if (!empty($assignedSections)) {
                $recentScansQuery->whereHas('student', function ($q) use ($assignedSections, $selectedSection) {
                    if ($selectedSection) {
                        $q->where('section', $selectedSection);
                    } else {
                        $q->whereIn('section', $assignedSections);
                    }
                });
            } else {
                $recentScansQuery->whereRaw('1 = 0');
            }
        } elseif ($selectedSection) {
            $recentScansQuery->whereHas('student', function ($q) use ($selectedSection) {
                $q->where('section', $selectedSection);
            });
        }

        $recentScans = $recentScansQuery->orderByDesc('updated_at')
            ->take(8)
            ->get();

        return compact(
            'students',
            'sections',
            'gradeLevels',
            'selectedDate',
            'selectedSection',
            'selectedGrade',
            'search',
            'totalStudents',
            'presentToday',
            'insideCampus',
            'departedToday',
            'lateToday',
            'absentToday',
            'excusedToday',
            'presenceRate',
            'recentScans'
        );
    }

    /**
     * Manual Override: Update attendance status, mark excused, and queue SMS alerts for absences.
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Late,Absent,Excused',
            'remarks' => 'nullable|string|max:255',
        ]);

        $student = Student::with('parents')->findOrFail($validated['student_id']);

        $user = auth()->user();
        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            $assignedSections = $teacher ? $teacher->assigned_sections : [];
            if (!$teacher || !in_array($student->section, $assignedSections)) {
                abort(403, 'Unauthorized action for student outside your assigned section(s).');
            }
        }

        $attendance = Attendance::firstOrNew([
            'student_id' => $validated['student_id'],
            'attendance_date' => $validated['attendance_date'],
        ]);

        $attendance->status = $validated['status'];
        $attendance->remarks = $validated['remarks'] ?? null;

        if ($validated['status'] === 'Present' && !$attendance->time_in) {
            $attendance->time_in = Carbon::now('Asia/Manila');
        }

        $attendance->save();

        // Cross-system Data Integration: Queue parent SMS notification when student is marked ABSENT
        if ($validated['status'] === 'Absent') {
            foreach ($student->parents as $parent) {
                $existingLog = SmsLog::where('student_id', $student->id)
                    ->where('parent_id', $parent->id)
                    ->whereDate('created_at', $validated['attendance_date'])
                    ->first();

                if (!$existingLog) {
                    SmsLog::create([
                        'student_id' => $student->id,
                        'parent_id' => $parent->id,
                        'attendance_id' => $attendance->id,
                        'message' => "VIP Learning Center Notice: Student {$student->first_name} {$student->last_name} was marked ABSENT for {$validated['attendance_date']}. Please contact the school office if you have any questions.",
                        'status' => 'Pending',
                        'sent_at' => Carbon::now('Asia/Manila'),
                    ]);
                }
            }
        }

        $studentName = "{$student->first_name} {$student->last_name}";
        $msg = "Attendance status updated for {$studentName} ({$validated['status']}).";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'status' => $validated['status'],
            ]);
        }

        return back()->with('success', $msg);
    }
}