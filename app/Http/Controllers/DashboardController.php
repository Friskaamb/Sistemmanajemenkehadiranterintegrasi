<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Attendance::count();

        return view('dashboard', compact('total'));
    }
}