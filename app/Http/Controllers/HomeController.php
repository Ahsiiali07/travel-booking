<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPackages = Package::with(['hotel', 'flight'])
            ->where('status', 'active')
            ->orderBy('is_featured', 'desc')
            ->take(6)
            ->get();

        $popularFlights = Flight::where('status', 'scheduled')
            ->where('departure_time', '>=', now())
            ->orderBy('departure_time', 'asc')
            ->take(6)
            ->get();

        $topHotels = Hotel::where('status', 'active')
            ->orderBy('star_rating', 'desc')
            ->take(6)
            ->get();

        $stats = [
            'total_packages' => Package::where('status', 'active')->count(),
            'total_hotels' => Hotel::where('status', 'active')->count(),
            'total_flights' => Flight::where('status', 'scheduled')->count(),
            'happy_travelers' => Reservation::where('payment_status', 'paid')->count() + 150,
        ];

        return view('home', compact('featuredPackages', 'popularFlights', 'topHotels', 'stats'));
    }
}
