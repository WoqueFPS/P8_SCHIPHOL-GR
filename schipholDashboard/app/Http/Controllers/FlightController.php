<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\DirectorBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{


    public function index()
    {
        $flights = Flight::orderBy('scheduled_time')->get();
        return view('flights.index', compact('flights'));
    }

    public function show(Flight $flight)
    {
        $alternativeFlights = collect();

        if ($flight->seats_available <= 0) {
            $alternativeFlights = Flight::where('destination', $flight->destination)
                ->where('id', '!=', $flight->id)
                ->where('seats_available', '>', 0)
                ->orderBy('departure_time')
                ->get();
        }

        return view('flights.show', compact('flight', 'alternativeFlights'));
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
        $this->authorizeStaff();

        $flights = Flight::all();
        $broadcast = DirectorBroadcast::getActiveBroadcast();

        return view('staff.flights.index', compact('flights', 'broadcast'));
    }

    public function create()
    {
        $this->authorizeStaff();
        $flight = new Flight();
        return view('staff.flights.manage', compact('flight'));
    }

    public function edit(Flight $flight)
    {
        $this->authorizeStaff();
        return view('staff.flights.manage', compact('flight'));
    }

    public function store(Request $request)
    {
        $this->authorizeStaff();
        $data = $this->validateData($request);

        if ($request->hasFile('airline_logo')) {
            $data['airline_logo'] = $request->file('airline_logo')->store('logos', 'public');
        }

        Flight::create($data);
        return redirect()->route('staff.flights.manage')->with('success', 'Vlucht succesvol toegevoegd.');
    }

    

    public function update(Request $request, Flight $flight)
    {
        $this->authorizeStaff();
        $data = $this->validateData($request);

        if ($request->hasFile('airline_logo')) {
            $data['airline_logo'] = $request->file('airline_logo')->store('logos', 'public');
        }

        $flight->update($data);
        return redirect()->route('staff.flights.manage')->with('success', 'Vlucht succesvol bijgewerkt.');
    }

    public function destroy(Flight $flight)
    {
        $this->authorizeStaff();
        $flight->delete();
        return redirect()->route('staff.flights.manage')->with('success', 'Vlucht succesvol verwijderd.');
    }



    private function authorizeStaff(): void
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff || !in_array($staff->role, ['coordinator', 'directeur'])) {
            abort(403, 'Alleen toegankelijk voor vluchtcoordinatoren en directie.');
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'flight_number'  => 'required|string|max:10',
            'airline'        => 'required|string|max:50',
            'airline_code'   => 'nullable|string|max:5',
            'airline_logo'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'origin'         => 'required|string|max:100',
            'destination'    => 'required|string|max:100',
            'gate'           => 'nullable|string|max:10',
            'terminal'       => 'nullable|string|max:5',
            'type'           => 'required|in:arriving,departing',
            'scheduled_time' => 'required|date_format:H:i',
            'delay_minutes'  => 'nullable|integer|min:0',
            'gate_type'      => 'required|in:standaard,uitgebreid',
            'status'         => 'required|in:op-tijd,vertraging,boarding,geland,geannuleerd,gepland,toekomstig',
        ]);
    }
}