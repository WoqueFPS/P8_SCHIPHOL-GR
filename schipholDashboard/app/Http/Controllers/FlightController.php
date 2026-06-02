<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        return view ('home');
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
}