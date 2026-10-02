<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentProfile;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Manila')->toDateString();

        // Count total active students, teachers, parents
        $studentCount = Student::where('status', 'Active')->count();
        if ($studentCount === 0) {
            $studentCount = Student::count();
        }

        $teacherCount = Teacher::count();
        if ($teacherCount === 0) {
            $teacherCount = User::where('role', 'teacher')->count();
        }

        $parentCount = ParentProfile::count();

        // Today's attendance records from single source of truth (`attendance` table)
        $todayAttendance = Attendance::whereDate('attendance_date', $today)->get();

        // Today's Present count (students who checked in today)
        $todayPresent = $todayAttendance->whereNotNull('time_in')->count();

        // Detailed overview counts
        $insideCampus = $todayAttendance->whereNotNull('time_in')->whereNull('time_out')->count();
        $departedCampus = $todayAttendance->whereNotNull('time_in')->whereNotNull('time_out')->count();
        $lateCount = $todayAttendance->where('status', 'Late')->count();
        $absentCount = max(0, $studentCount - $todayPresent);

        $presenceRate = $studentCount > 0 ? round(($todayPresent / $studentCount) * 100) : 0;

        // Recent scans across campus (strictly filtered to today's date, latest 5)
        $recentScans = Attendance::with(['student', 'guardProfile'])
            ->whereDate('attendance_date', $today)
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'studentCount',
            'teacherCount',
            'parentCount',
            'todayPresent',
            'insideCampus',
            'departedCampus',
            'lateCount',
            'absentCount',
            'presenceRate',
            'recentScans'
        ));
    }
}