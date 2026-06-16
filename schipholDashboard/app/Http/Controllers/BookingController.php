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
    /**
     * Toon alle boekingen
     */
    public function index()
    {
        $bookings = Booking::with('flight')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Toon boeking formulier voor een vlucht
     */
    public function create($flightId)
    {
        $flight = Flight::findOrFail($flightId);
        
        // Alternatieve vluchten (als deze vol is)
        $alternativeFlights = Flight::where('id', '!=', $flightId)
            ->where('destination', $flight->destination)
            ->where('seats_available', '>', 0)
            ->limit(3)
            ->get();
        
        return view('bookings.create', compact('flight', 'alternativeFlights'));
    }

    /**
     * Sla boeking op
     */
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

        $flight = Flight::findOrFail($request->flight_id);

        // Controleer of vlucht boekbaar is
        if (!in_array($flight->status, ['op-tijd', 'vertraging', 'scheduled'])) {
            return back()->withErrors(['flight_id' => 'Deze vlucht is niet beschikbaar voor boeking.']);
        }

        // Controleer beschikbare stoelen
        if ($flight->seats_available <= 0) {
            return back()->with('error', 'Deze vlucht is helaas volgeboekt. Kies een alternatieve vlucht.');
        }

        // Genereer uniek boekingsnummer
        $bookingNumber = 'BK-' . strtoupper(Str::random(8));

        // Maak boeking aan
        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'flight_id'      => $flight->id,
            'user_id'        => auth()->id() ?? null,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'address'        => $request->address,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'status'         => 'confirmed',
        ]);

        // Verminder beschikbare stoelen
        $flight->decrement('seats_available');

        // Stuur bevestigingsmail (optioneel)
        try {
            Mail::to($booking->email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            // Log error maar ga door
            \Log::error('Mail niet verzonden: ' . $e->getMessage());
        }

        return redirect()
            ->route('bookings.confirmation', $booking->booking_number)
            ->with('success', 'Boeking succesvol! Je boekingsnummer is: ' . $bookingNumber);
    }

    /**
     * Toon boekingsbevestiging
     */
    public function confirmation($bookingNumber)
    {
        $booking = Booking::with('flight')
            ->where('booking_number', $bookingNumber)
            ->firstOrFail();

        return view('bookings.confirmation', compact('booking'));
    }

    /**
     * Toon een specifieke boeking
     */
    public function show($booking)
    {
        $booking = Booking::with('flight')->findOrFail($booking);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Annuleer een boeking
     */
    public function cancel($booking)
    {
        $booking = Booking::findOrFail($booking);
        $booking->update(['status' => 'cancelled']);
        
        // Voeg stoelen weer toe
        if ($booking->flight) {
            $booking->flight->increment('seats_available');
        }

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Boeking geannuleerd.');
    }
}