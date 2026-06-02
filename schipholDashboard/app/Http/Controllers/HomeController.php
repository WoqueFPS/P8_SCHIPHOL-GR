<?php

namespace App\Http\Controllers;

use App\Models\Flight;

class HomeController extends Controller
{
    public function index()
    {
        $arriving  = Flight::arriving()->orderBy('scheduled_time')->get();
        $departing = Flight::departing()->orderBy('scheduled_time')->get();

        $popularDestinations = Flight::departing()
            ->selectRaw('destination, COUNT(*) as total')
            ->groupBy('destination')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $stats = [
            'total'        => Flight::count(),
            'on_time'      => Flight::where('status', 'op-tijd')->count(),
            'terminals'    => Flight::distinct('terminal')->count('terminal'),
            'destinations' => Flight::distinct('destination')->count('destination'),
        ];

        return view('home', compact(
            'arriving', 'departing', 'popularDestinations', 'stats'
        ));
    }
}