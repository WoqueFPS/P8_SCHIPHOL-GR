<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store()
    {
        return "Booking opgeslagen";
    }

    public function show($booking)
    {
        return "Booking: " . $booking;
    }

    public function cancel($booking)
    {
        return "Booking geannuleerd";
    }
}