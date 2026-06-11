<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();
        if ($staff->role === 'directeur') {
            $coordinatoren = Coordinator::all();

            $totaalCoordinatoren = $coordinatoren->count();
            $actieveVluchten = 48; 
            $openMeldingen = 3;    

            return view('staff.reports.index', compact(
                'staff', 
                'coordinatoren', 
                'totaalCoordinatoren', 
                'actieveVluchten', 
                'openMeldingen'
            ));
        }

        return match ($staff->role) {
            'vluchtcoordinator' => redirect()->route('staff.flights.index'),
            default => view('staff.dashboard', compact('staff')),
        };
    }
}