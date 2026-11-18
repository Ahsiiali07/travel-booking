<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::where('status', 'active');

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('stars')) {
            $query->where('star_rating', '>=', $request->stars);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        $hotels = $query->orderBy('star_rating', 'desc')->paginate(9);

        return view('hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        $nearbyHotels = Hotel::where('id', '!=', $hotel->id)
            ->where('city', $hotel->city)
            ->where('status', 'active')
            ->take(3)
            ->get();

        return view('hotels.show', compact('hotel', 'nearbyHotels'));
    }
}
