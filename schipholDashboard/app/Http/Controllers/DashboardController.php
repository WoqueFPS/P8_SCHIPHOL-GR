<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Auth;
 
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
 
        // NOTE: de 'bookings' tabel heeft nog geen 'user_id' kolom,
        // dus boekingen kunnen hier nog niet gekoppeld worden aan de gebruiker.
        // Zodra die kolom is toegevoegd, kan dit blok weer aan.
 
        // Wishlist van de ingelogde gebruiker
        $wishlistFlights = $user->wishlistFlights()->get();
        $recentWishlist = $wishlistFlights->take(3);
        $wishlistCount = $wishlistFlights->count();
 
        return view('dashboard', [
            'user' => $user,
            'recentWishlist' => $recentWishlist,
            'wishlistCount' => $wishlistCount,
        ]);
    }
}