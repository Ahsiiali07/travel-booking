<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $tab = $request->get('tab', 'packages'); // 'flights', 'hotels', or 'packages'

        // 1. Flights Search Query
        $flightsQuery = Flight::where('status', 'scheduled');

        if ($request->filled('origin')) {
            $rawOrigin = trim($request->origin);
            $originCode = null;
            if (preg_match('/\(([A-Z]{3})\)/', $rawOrigin, $matches)) {
                $originCode = $matches[1];
            } elseif (preg_match('/^([A-Za-z]{3})$/', $rawOrigin, $matches)) {
                $originCode = strtoupper($matches[1]);
            }
            $originCity = trim(preg_replace('/\([A-Za-z0-9\s]+\)/', '', $rawOrigin));

            $flightsQuery->where(function($q) use ($rawOrigin, $originCity, $originCode) {
                if (!empty($originCity)) {
                    $q->where('origin_city', 'like', "%{$originCity}%")
                      ->orWhere('origin_airport', 'like', "%{$originCity}%");
                }
                if ($originCode) {
                    $q->orWhere('origin_airport', 'like', "%{$originCode}%")
                      ->orWhere('origin_city', 'like', "%{$originCode}%");
                }
                if (empty($originCity) && empty($originCode)) {
                    $q->where('origin_city', 'like', "%{$rawOrigin}%")
                      ->orWhere('origin_airport', 'like', "%{$rawOrigin}%");
                }
            });
        }
        if ($request->filled('destination')) {
            $rawDest = trim($request->destination);
            $destCode = null;
            if (preg_match('/\(([A-Z]{3})\)/', $rawDest, $matches)) {
                $destCode = $matches[1];
            } elseif (preg_match('/^([A-Za-z]{3})$/', $rawDest, $matches)) {
                $destCode = strtoupper($matches[1]);
            }
            $destCity = trim(preg_replace('/\([A-Za-z0-9\s]+\)/', '', $rawDest));

            $flightsQuery->where(function($q) use ($rawDest, $destCity, $destCode) {
                if (!empty($destCity)) {
                    $q->where('destination_city', 'like', "%{$destCity}%")
                      ->orWhere('destination_airport', 'like', "%{$destCity}%");
                }
                if ($destCode) {
                    $q->orWhere('destination_airport', 'like', "%{$destCode}%")
                      ->orWhere('destination_city', 'like', "%{$destCode}%");
                }
                if (empty($destCity) && empty($destCode)) {
                    $q->where('destination_city', 'like', "%{$rawDest}%")
                      ->orWhere('destination_airport', 'like', "%{$rawDest}%");
                }
            });
        }
        if ($request->filled('flight_date')) {
            $flightsQuery->whereDate('departure_time', $request->flight_date);
        }
        if ($request->filled('seat_class')) {
            $flightsQuery->where('seat_class', $request->seat_class);
        }
        if ($request->filled('max_flight_price')) {
            $flightsQuery->where('price_per_seat', '<=', $request->max_flight_price);
        }
        $flights = $flightsQuery->orderBy('price_per_seat', 'asc')->paginate(9, ['*'], 'flights_page');

        // 2. Hotels Search Query
        $hotelsQuery = Hotel::where('status', 'active');

        if ($request->filled('hotel_city')) {
            $hotelsQuery->where(function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->hotel_city . '%')
                  ->orWhere('name', 'like', '%' . $request->hotel_city . '%');
            });
        }
        if ($request->filled('star_rating')) {
            $hotelsQuery->where('star_rating', '>=', $request->star_rating);
        }
        if ($request->filled('max_hotel_price')) {
            $hotelsQuery->where('price_per_night', '<=', $request->max_hotel_price);
        }
        $hotels = $hotelsQuery->orderBy('star_rating', 'desc')->paginate(9, ['*'], 'hotels_page');

        // 3. Packages Search Query
        $packagesQuery = Package::with(['hotel', 'flight'])->where('status', 'active');

        if ($request->filled('package_destination')) {
            $packagesQuery->where(function($q) use ($request) {
                $q->where('destination', 'like', '%' . $request->package_destination . '%')
                  ->orWhere('name', 'like', '%' . $request->package_destination . '%');
            });
        }
        if ($request->filled('duration')) {
            $packagesQuery->where('duration_days', '<=', $request->duration);
        }
        if ($request->filled('max_package_price')) {
            $packagesQuery->where('price', '<=', $request->max_package_price);
        }
        $packages = $packagesQuery->orderBy('is_featured', 'desc')->orderBy('price', 'asc')->paginate(9, ['*'], 'packages_page');

        return view('search', compact('tab', 'flights', 'hotels', 'packages'));
    }
}
