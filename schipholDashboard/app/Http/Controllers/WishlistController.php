<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add($flightId)
    {
        auth()->user()->wishlistFlights()->syncWithoutDetaching([$flightId]);
        return back();
    }

    public function remove($flightId)
    {
        auth()->user()->wishlistFlights()->detach($flightId);
        return back();
    }

    public function index()
    {
        $flights = auth()->user()->wishlistFlights;
        return view('wishlist.index', compact('flights'));
    }
}
