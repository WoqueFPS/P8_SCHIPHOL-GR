<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {   
        //extra
        if (!auth()->user() || !in_array(auth()->user()->role, ['director', 'admin'])) {
            abort(403, 'Alleen toegankelijk voor de directie.');
        }

        $coordinators = User::where('role', 'coordinator')->get();
        $bookings = Booking::all();

        return view('reports.index', compact('coordinators', 'bookings'));
    }
}