<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\GuardDashboardController;
use App\Http\Controllers\ParentDashboardController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {


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


});


require __DIR__.'/auth.php';