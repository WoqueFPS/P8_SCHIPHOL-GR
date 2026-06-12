<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    public function index()
    {
        $flights = \App\Models\Flight::all();
        return view('staff.flights.index', compact('flights'));
    }

    public function show($id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
        return view('flights.show', compact('flight'));
    }

    public function search()
    {
        return "Search werkt";
    }

    public function addToWishlist($flight)
    {
        return "Added to wishlist " . $flight;
    }

    public function removeFromWishlist($flight)
    {
        return "Removed from wishlist " . $flight;
    }

    public function manage()
    {
        // check for staff guard with role
        $staff = Auth::guard('staff')->user();
        
        if (!$staff || !in_array($staff->role, ['coordinator', 'directeur'])) {
            abort(403, 'Alleen toegankelijk voor vluchtcoordinatoren en directie.');
        }

        $flights = \App\Models\Flight::all();

        return view('staff.flights.manage', compact('flights'));
    }
}
