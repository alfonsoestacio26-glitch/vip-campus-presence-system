<?php

namespace App\Http\Controllers;

use App\Models\ParentProfile;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    /**
     * Display the real-time Parent Dashboard for monitoring children's campus presence.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Resolve ParentProfile for authenticated user
        $parent = null;
        if ($user) {
            $parent = $user->parentProfile ?? ParentProfile::where('user_id', $user->id)->first();
        }

        // Fallback for admin preview only
        if (!$parent && $user && $user->role === 'admin') {
            $parent = ParentProfile::has('students')->first() ?? ParentProfile::first();
        }

        // 2. Load linked children sorted alphabetically by surname
        $children = collect();
        if ($parent) {
            $children = $parent->students()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->with([
                    'attendances' => function ($q) {
                        $q->orderByDesc('attendance_date')->orderByDesc('time_in');
                    }
                ])
                ->get();
        }

        // 3. Determine selected child & enforce backend security check
        $selectedChildId = $request->input('child_id');
        $selectedStudent = null;

        if ($selectedChildId) {
            $selectedStudent = $children->firstWhere('id', $selectedChildId);
            
            // SECURITY: If student ID was passed but does NOT belong to this parent -> 403 Forbidden
            if (!$selectedStudent && $user->role === 'parent') {
                abort(403, 'Forbidden. The requested student is not linked to your account.');
            }
        }

        if (!$selectedStudent && $children->isNotEmpty()) {
            $selectedStudent = $children->first();
        }

        // 4. Calculate presence details for selected child
        $today = Carbon::now('Asia/Manila')->toDateString();
        $todayAttendance = null;
        $presenceStatus = 'Absent';
        $statusBadge = [
            'label' => 'NOT YET ON CAMPUS / ABSENT',
            'sub' => 'No gate scan recorded for today as of ' . Carbon::now('Asia/Manila')->format('h:i A') . '.',
            'color' => 'rose',
            'icon' => 'fa-solid fa-clock-rotate-left',
        ];

        $attendanceLogs = collect();
        $stats = [
            'total_present' => 0,
            'total_late' => 0,
            'total_absent' => 0,
            'total_excused' => 0,
            'attendance_rate' => 0,
        ];

        if ($selectedStudent) {
            // Today's attendance
            $todayAttendance = Attendance::with('guardProfile')
                ->where('student_id', $selectedStudent->id)
                ->whereDate('attendance_date', $today)
                ->first();

            if ($todayAttendance) {
                if ($todayAttendance->status === 'Excused') {
                    $presenceStatus = 'Excused';
                    $statusBadge = [
                        'label' => 'EXCUSED ABSENCE',
                        'sub' => $todayAttendance->remarks ?: 'Excused by School Teacher / Administrator.',
                        'color' => 'purple',
                        'icon' => 'fa-solid fa-notes-medical',
                    ];
                } elseif ($todayAttendance->time_in && !$todayAttendance->time_out) {
                    $presenceStatus = 'Inside Campus';
                    $statusBadge = [
                        'label' => 'CURRENTLY INSIDE CAMPUS',
                        'sub' => 'Verified at gate kiosk. Child is on campus grounds.',
                        'color' => 'emerald',
                        'icon' => 'fa-solid fa-school-flag',
                    ];
                } elseif ($todayAttendance->time_in && $todayAttendance->time_out) {
                    $presenceStatus = 'Departed';
                    $statusBadge = [
                        'label' => 'DEPARTED CAMPUS',
                        'sub' => 'Child scanned out at gate terminal at ' . Carbon::parse($todayAttendance->time_out)->format('h:i A') . '.',
                        'color' => 'sky',
                        'icon' => 'fa-solid fa-door-open',
                    ];
                } elseif ($todayAttendance->status === 'Late') {
                    $presenceStatus = 'Late';
                    $statusBadge = [
                        'label' => 'LATE ARRIVAL (INSIDE CAMPUS)',
                        'sub' => 'Checked in past normal school schedule at ' . Carbon::parse($todayAttendance->time_in)->format('h:i A') . '.',
                        'color' => 'amber',
                        'icon' => 'fa-solid fa-clock',
                    ];
                }
            }

            // Attendance history log for this student
            $attendanceLogs = Attendance::with('guardProfile')
                ->where('student_id', $selectedStudent->id)
                ->orderByDesc('attendance_date')
                ->orderByDesc('time_in')
                ->take(30)
                ->get();

            // Calculate overall stats for this student
            $totalPresent = $selectedStudent->attendances->whereNotNull('time_in')->count();
            $totalLate = $selectedStudent->attendances->where('status', 'Late')->count();
            $totalExcused = $selectedStudent->attendances->where('status', 'Excused')->count();
            $totalDaysLogged = $selectedStudent->attendances->count();

            $rate = $totalDaysLogged > 0 ? round(($totalPresent / $totalDaysLogged) * 100) : 100;

            $stats = [
                'total_present' => $totalPresent,
                'total_late' => $totalLate,
                'total_absent' => max(0, $totalDaysLogged - $totalPresent - $totalExcused),
                'total_excused' => $totalExcused,
                'attendance_rate' => $rate,
            ];
        }

        // 5. School Announcements
        $announcements = Announcement::with('teacher')->latest()->take(4)->get();

        return view('parents.dashboard', compact(
            'parent',
            'children',
            'selectedStudent',
            'todayAttendance',
            'presenceStatus',
            'statusBadge',
            'attendanceLogs',
            'stats',
            'announcements',
            'today'
        ));
    }

    /**
     * Display a specific linked child's dashboard view.
     */
    public function showChild(Request $request, Student $student)
    {
        $user = Auth::user();

        if ($user->role === 'parent') {
            $parent = $user->parentProfile;
            if (!$parent || !$parent->students()->where('students.id', $student->id)->exists()) {
                abort(403, 'Forbidden. This student is not linked to your parent account.');
            }
        }

        $request->merge(['child_id' => $student->id]);
        return $this->index($request);
    }
}
