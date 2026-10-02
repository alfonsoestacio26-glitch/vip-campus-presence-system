<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\GuardDashboardController;
use App\Http\Controllers\ParentDashboardController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\AttendanceController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| Authentication Required Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Main Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        return redirect('/' . $role . '/dashboard');

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [
        AdminDashboardController::class,
        'index'
    ])
        ->middleware('role:admin')
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Teacher Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/teacher/dashboard', [
        TeacherDashboardController::class,
        'index'
    ])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::get('/teacher/dashboard/live-data', [
        TeacherDashboardController::class,
        'liveData'
    ])
        ->middleware('role:teacher')
        ->name('teacher.dashboard.live');

    Route::post('/teacher/attendance/status', [
        TeacherDashboardController::class,
        'updateStatus'
    ])
        ->middleware('role:teacher')
        ->name('teacher.attendance.status');

    Route::get('/teacher/students', [
        StudentController::class,
        'teacherIndex'
    ])
        ->middleware('role:teacher')
        ->name('teacher.students.index');

    Route::get('/teacher/students/{student}', [
        StudentController::class,
        'teacherShow'
    ])
        ->middleware('role:teacher')
        ->name('teacher.students.show');

    Route::get('/teacher/attendance', [
        AttendanceController::class,
        'teacherIndex'
    ])
        ->middleware('role:teacher')
        ->name('teacher.attendance.index');
    /*
    |--------------------------------------------------------------------------
    | Guard Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/guard/dashboard', [
        GuardDashboardController::class,
        'index'
    ])
        ->middleware('role:guard')
        ->name('guard.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Guard Scan History & Logs
    |--------------------------------------------------------------------------
    */

    Route::get('/guard/history', [
        GuardDashboardController::class,
        'history'
    ])
        ->middleware('role:guard')
        ->name('guard.history');


    /*
    |--------------------------------------------------------------------------
    | Guard QR Scanner (Alias to Guard Dashboard)
    |--------------------------------------------------------------------------
    */

    Route::get('/guard/scanner', function () {
        return redirect()->route('guard.dashboard');
    })
        ->middleware('role:guard')
        ->name('guard.scanner');


    /*
    |--------------------------------------------------------------------------
    | Guard QR Attendance Scan
    |--------------------------------------------------------------------------
    */

    Route::post('/guard/attendance/scan', [
        AttendanceController::class,
        'scan'
    ])
        ->middleware('role:guard')
        ->name('attendance.scan');


    /*
    |--------------------------------------------------------------------------
    | Parent Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/parent/dashboard', [
        ParentDashboardController::class,
        'index'
    ])
        ->middleware('role:parent')
        ->name('parent.dashboard');

    Route::get('/parent/students/{student}', [
        ParentDashboardController::class,
        'showChild'
    ])
        ->middleware('role:parent')
        ->name('parent.students.show');


    /*
    |--------------------------------------------------------------------------
    | Student Management (Batch CSV & Badge Printing)
    |--------------------------------------------------------------------------
    */

    Route::get('/students/export', [StudentController::class, 'exportCsv'])
        ->middleware('role:admin')
        ->name('students.export');

    Route::get('/students/import/template', [StudentController::class, 'downloadTemplate'])
        ->middleware('role:admin')
        ->name('students.import.template');

    Route::post('/students/import', [StudentController::class, 'importCsv'])
        ->middleware('role:admin')
        ->name('students.import');

    Route::get('/students/badges/batch', [StudentController::class, 'batchBadges'])
        ->middleware('role:admin')
        ->name('students.badges.batch');

    Route::get('/students/{student}/badge', [StudentController::class, 'badge'])
        ->middleware('role:admin')
        ->name('students.badge');

    Route::resource('students', StudentController::class)
        ->middleware('role:admin');

    Route::post('/students/{student}/photo', [StudentController::class, 'updatePhoto'])
        ->middleware('role:admin')
        ->name('students.photo.update');


    /*
    |--------------------------------------------------------------------------
    | Parent Management
    |--------------------------------------------------------------------------
    */

    Route::resource('parents', ParentController::class)
        ->middleware('role:admin');

    Route::post('/parents/{parent}/photo', [ParentController::class, 'updatePhoto'])
        ->middleware('role:admin')
        ->name('parents.photo.update');


    /*
    |--------------------------------------------------------------------------
    | Parent ↔ Student Relationship
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/parents/{parent}/students',
        [ParentController::class, 'attachStudent']
    )
        ->middleware('role:admin')
        ->name('parents.students.attach');


    Route::delete(
        '/parents/{parent}/students/{student}',
        [ParentController::class, 'detachStudent']
    )
        ->middleware('role:admin')
        ->name('parents.students.detach');


    /*
    |--------------------------------------------------------------------------
    | Teacher Management
    |--------------------------------------------------------------------------
    */

    Route::resource('teachers', TeacherController::class)
        ->middleware('role:admin');

    Route::post('/teachers/{teacher}/photo', [TeacherController::class, 'updatePhoto'])
        ->middleware('role:admin')
        ->name('teachers.photo.update');


    /*
    |--------------------------------------------------------------------------
    | Guard Management
    |--------------------------------------------------------------------------
    */

    Route::resource('guards', GuardController::class)
        ->middleware('role:admin');

    Route::post('/guards/{guard}/photo', [GuardController::class, 'updatePhoto'])
        ->middleware('role:admin')
        ->name('guards.photo.update');


    /*
    |--------------------------------------------------------------------------
    | Attendance Management
    |--------------------------------------------------------------------------
    */

    Route::resource('attendance', AttendanceController::class)
        ->middleware('role:admin');


    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        \App\Http\Controllers\ProfileController::class,
        'edit'
    ])
        ->name('profile.edit');


    Route::patch('/profile', [
        \App\Http\Controllers\ProfileController::class,
        'update'
    ])
        ->name('profile.update');


    Route::delete('/profile', [
        \App\Http\Controllers\ProfileController::class,
        'destroy'
    ])
        ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';