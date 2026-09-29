<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    /**
     * Display the interactive Teacher Dashboard with section presence overview and student attendance list.
     */
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::now('Asia/Manila')->toDateString());
        $selectedSection = $request->input('section', '');
        $selectedGrade = $request->input('grade_level', '');
        $search = trim($request->input('search', ''));

        // All available sections and grades for dropdown filters
        $sections = Student::distinct()->whereNotNull('section')->where('section', '!=', '')->pluck('section')->sort()->values();
        $gradeLevels = Student::distinct()->whereNotNull('grade_level')->where('grade_level', '!=', '')->pluck('grade_level')->sort()->values();

        // Query students
        $studentQuery = Student::where('status', 'Active');

        if ($selectedSection) {
            $studentQuery->where('section', $selectedSection);
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
            ->where('attendance_date', $selectedDate)
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
                }
            } else {
                $student->presence_status = 'Absent';
                $absentToday++;
            }
        }

        $presenceRate = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100) : 0;

        // Recent live gate scans for the live feed widget
        $recentScans = Attendance::with('student')
            ->where('attendance_date', $selectedDate)
            ->orderByDesc('updated_at')
            ->take(8)
            ->get();

        return view('teacher.dashboard', compact(
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
        ));
    }

    /**
     * Update attendance status or excuse an absence.
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:Present,Late,Absent,Excused',
            'remarks' => 'nullable|string|max:255',
        ]);

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

        $student = Student::find($validated['student_id']);
        $studentName = $student ? "{$student->first_name} {$student->last_name}" : 'Student';

        return back()->with('success', "Attendance status updated for {$studentName} ({$validated['status']}).");
    }
}