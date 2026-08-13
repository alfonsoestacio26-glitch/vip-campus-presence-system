<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuardDashboardController extends Controller
{
    public function index()
    {
        return view('guard.dashboard');
    }
}
