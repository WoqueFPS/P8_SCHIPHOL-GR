<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {   
        $staff = Auth::guard('staff')->user();
        
        if (!$staff || $staff->role !== 'directeur') {
            abort(403, 'Alleen toegankelijk voor de directie.');
        }

        $coordinators = Staff::where('role', 'coordinator')->get();

        // Updated path: staff.reports.index
        return view('staff.reports.index', compact('coordinators'));
    }
}