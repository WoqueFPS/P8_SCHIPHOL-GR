<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        return match ($staff->role) {
            'directeur' => redirect()->route('staff.reports.index'),
            'vluchtcoordinator' => redirect()->route('staff.flights.index'),
            default => view('staff.dashboard', compact('staff')),
        };
    }
}