<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'confirm'    => 'accepted'
        ]);

        $booking = Booking::create([
            'booking_number' => Str::uuid(),

            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'address'    => $validated['address'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
        ]);

        return redirect()->route('bookings.confirmation', [
            'bookingNumber' => $booking->booking_number
        ]);
    }

    public function confirmation($bookingNumber)
    {
        return view('booking.confirmation', [
            'bookingNumber' => $bookingNumber
        ]);
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
