<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $flights = \App\Models\Flight::all();
        return view('flights.index', compact('flights'));
    }

    public function show($flight)
    {
        return "Show flight " . $flight;
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
        // extra security
        if (!auth()->user() || !in_array(auth()->user()->role, ['coordinator', 'admin'])) {
            abort(403, 'Alleen toegankelijk voor vluchtcoordinatoren.');
        }

        $flights = \App\Models\Flight::all();

        return view('flights.manage', compact('flights'));
    }
}