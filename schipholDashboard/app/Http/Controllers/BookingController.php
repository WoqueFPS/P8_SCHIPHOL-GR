<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'confirm'    => 'accepted',
            'flight_id'  => 'required|exists:flights,id',
        ]);

        // Controleer of vlucht boekbaar is
        $flight = Flight::findOrFail($request->flight_id);
        if (!in_array($flight->status, ['op-tijd', 'vertraging'])) {
            return back()->withErrors(['flight_id' => 'Deze vlucht is niet beschikbaar voor boeking.']);
        }

        $booking = Booking::create([
            'booking_number' => Str::uuid(),
            'flight_id'      => $flight->id,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'address'        => $request->address,
            'email'          => $request->email,
            'phone'          => $request->phone,
        ]);

        $flight->decrement('seats_available');

        Mail::to($booking->email)->send(new BookingConfirmation($booking));

        return redirect()->route('bookings.confirmation', [
            'bookingNumber' => $booking->booking_number
        ]);

        $flight = Flight::findOrFail($request->flight_id);

        if ($flight->seats_available <= 0) {
            return redirect()
                ->route('flights.show', $flight->id)
                ->with('error', 'Deze vlucht is volgeboekt. Kies een alternatieve vlucht.');
        }
    }

    public function confirmation($bookingNumber)
    {
        $booking = Booking::with('flight', 'traveler')
            ->where('booking_number', $bookingNumber)
            ->firstOrFail();

        return view('bookings.confirmation', compact('booking'));
    }

    public function show($booking)
    {
        return "Booking: " . $booking;
    }

    public function cancel($booking)
    {
        return "Booking geannuleerd";
    }

    public function index()
    {
        $bookings = Booking::with('flight')->get();
        return view('bookings.index', compact('bookings'));
    }
}