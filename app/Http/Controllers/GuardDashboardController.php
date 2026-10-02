<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;

class GuardDashboardController extends Controller
{
    /**
     * Main Guard Dashboard - QR Scanner Kiosk Screen
     */
    public function index()
    {
        $today = \Carbon\Carbon::now('Asia/Manila')->toDateString();

        $recentScans = Attendance::with('student')
            ->whereDate('attendance_date', $today)
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        return view('guards.dashboard', compact('recentScans'));
    }

    /**
     * Guard Attendance History & Statistics Logs
     */
    public function history()
    {
        // Today's date
        $today = \Carbon\Carbon::now('Asia/Manila')->toDateString();

        // Total registered students
        $totalStudents = Student::count();

        // Today's attendance records
        $todayAttendance = Attendance::with(['student', 'guardProfile'])
            ->whereDate('attendance_date', $today)
            ->orderByDesc('time_in')
            ->get();

        // Students who have timed in today
        $timeInCount = Attendance::whereDate('attendance_date', $today)
            ->whereNotNull('time_in')
            ->count();

        // Students who have already timed out today
        $timeOutCount = Attendance::whereDate('attendance_date', $today)
            ->whereNotNull('time_out')
            ->count();

        // Students currently inside the campus
        $currentlyOnCampus = Attendance::whereDate('attendance_date', $today)
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->count();

        // Recent scans
        $recentScans = Attendance::with('student')
            ->whereDate('attendance_date', $today)
            ->orderByDesc('updated_at')
            ->take(15)
            ->get();

        return view('guards.history', compact(
            'totalStudents',
            'todayAttendance',
            'timeInCount',
            'timeOutCount',
            'currentlyOnCampus',
            'recentScans'
        ));
    }
}