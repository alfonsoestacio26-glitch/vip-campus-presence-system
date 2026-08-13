<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count students
        $studentCount = Student::count();

        // Count teachers
        $teacherCount = User::where('role', 'teacher')->count();

        // Count parents
        $parentCount = User::where('role', 'parent')->count();

        // Today's present
        $todayPresent = 0;

        return view('admin.dashboard', compact(
            'studentCount',
            'teacherCount',
            'parentCount',
            'todayPresent'
        ));
    }
}