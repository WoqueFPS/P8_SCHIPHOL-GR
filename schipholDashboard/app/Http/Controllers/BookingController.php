<?php

namespace App\Http\Controllers;

use App\Models\Booking; // <-- Vergeet deze niet te importeren!
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- Belangrijk voor het unieke nummer!

class BookingController extends Controller
{
    public function store(Request $request) // <-- Voeg (Request $request) toe
    {
        // 1. Validatie van de gegevens
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        // 2. Opslaan in de database met een unieke UUID
        $booking = Booking::create([
            'booking_number' => Str::uuid(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // 3. Doorsturen naar de bevestigingspagina
        return redirect()->route('bookings.confirmation', [
            'bookingNumber' => $booking->booking_number
        ]);
    }

    // Dit is de nieuwe methode voor de bevestigingspagina
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
