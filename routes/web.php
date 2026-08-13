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


Route::resource('students', StudentController::class);
Route::resource('parents', ParentController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('guards', GuardController::class);


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect('/' . $role . '/dashboard');
    })->name('dashboard');

    Route::get('/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->middleware('role:admin');


    Route::get('/teacher/dashboard',
        [TeacherDashboardController::class, 'index']
    )->middleware('role:teacher');


    Route::get('/guard/dashboard',
        [GuardDashboardController::class, 'index']
    )->middleware('role:guard');


    Route::get('/parent/dashboard',
        [ParentDashboardController::class, 'index']
    )->middleware('role:parent');

    

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';