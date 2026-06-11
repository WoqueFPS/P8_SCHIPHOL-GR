<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Flight;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function checkDirecteur()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff || $staff->role !== 'directeur') {
            abort(403, 'Alleen toegankelijk voor de directie.');
        }
        return $staff;
    }

    public function index()
    {   
        $staff = $this->checkDirecteur();
        $coordinatoren = Staff::where('role', 'coordinator')->get();
        $totaalCoordinatoren = $coordinatoren->count();

        $actieveVluchten = Flight::count(); 
        $openMeldingen = 3; 
        
        return view('staff.reports.index', compact(
            'staff',
            'coordinatoren', 
            'totaalCoordinatoren', 
            'actieveVluchten', 
            'openMeldingen'
        ));
    }

    public function create()
    {
        $this->checkDirecteur();
        return view('staff.reports.create');
    }

    public function store(Request $request)
    {
        $this->checkDirecteur();

        $request->validate([
            'naam' => 'required|string|max:255',
            'afdeling' => 'required|string|max:255',
        ]);

        $cleanName = strtolower(str_replace(' ', '', $request->naam));
        $generatedEmail = $cleanName . '.' . rand(10, 99) . '@schiphol.nl';

        Staff::create([
            'name' => $request->naam,
            'department' => $request->afdeling, 
            'email' => $generatedEmail,         
            'password' => bcrypt('Welkom01!'),   
            'role' => 'coordinator',
        ]);

        return redirect()->route('staff.reports.index');
    }

    public function edit($id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);
        return view('staff.reports.edit', compact('coordinator'));
    }

    public function update(Request $request, $id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);

        $request->validate([
            'naam' => 'required|string|max:255',
            'afdeling' => 'required|string|max:255',
        ]);

        $coordinator->update([
            'name' => $request->naam,
            'department' => $request->afdeling,
        ]);

        return redirect()->route('staff.reports.index');
    }

    public function destroy($id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);
        $coordinator->delete();

        return redirect()->route('staff.reports.index');
    }
}