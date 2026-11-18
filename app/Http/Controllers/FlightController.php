<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::where('status', 'scheduled');

        if ($request->filled('origin')) {
            $rawOrigin = trim($request->origin);
            $originCode = null;
            if (preg_match('/\(([A-Z]{3})\)/', $rawOrigin, $matches)) {
                $originCode = $matches[1];
            } elseif (preg_match('/^([A-Za-z]{3})$/', $rawOrigin, $matches)) {
                $originCode = strtoupper($matches[1]);
            }
            $originCity = trim(preg_replace('/\([A-Za-z0-9\s]+\)/', '', $rawOrigin));

            $query->where(function($q) use ($rawOrigin, $originCity, $originCode) {
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

            $query->where(function($q) use ($rawDest, $destCity, $destCode) {
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
        if ($request->filled('date')) {
            $query->whereDate('departure_time', $request->date);
        }
        if ($request->filled('class')) {
            $query->where('seat_class', $request->class);
        }

        $flights = $query->orderBy('departure_time', 'asc')->paginate(10);

        return view('flights.index', compact('flights'));
    }

    public function show(Flight $flight)
    {
        $relatedFlights = Flight::where('id', '!=', $flight->id)
            ->where('status', 'scheduled')
            ->where('origin_city', $flight->origin_city)
            ->take(3)
            ->get();

        return view('flights.show', compact('flight', 'relatedFlights'));
    }
}
