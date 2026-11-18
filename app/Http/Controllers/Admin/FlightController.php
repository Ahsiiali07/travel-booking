<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Read: List all flights.
     */
    public function index(Request $request)
    {
        $query = Flight::query();

        if ($request->filled('search')) {
            $query->where('airline', 'like', '%' . $request->search . '%')
                  ->orWhere('flight_number', 'like', '%' . $request->search . '%')
                  ->orWhere('origin_city', 'like', '%' . $request->search . '%')
                  ->orWhere('destination_city', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $flights = $query->withCount('reservations')->orderBy('departure_time', 'asc')->paginate(10);

        return view('admin.flights.index', compact('flights'));
    }

    /**
     * Create: Show form.
     */
    public function create()
    {
        return view('admin.flights.create');
    }

    /**
     * Create: Store new flight.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'airline' => 'required|string|max:100',
            'flight_number' => 'required|string|max:50|unique:flights,flight_number',
            'origin_city' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'origin_airport' => 'required|string|max:150',
            'destination_airport' => 'required|string|max:150',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'duration' => 'required|string|max:50',
            'seat_class' => 'required|in:Economy,Business,First Class',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0',
            'price_per_seat' => 'required|numeric|min:0',
            'baggage_allowance' => 'nullable|string|max:100',
            'aircraft_type' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'status' => 'required|in:scheduled,delayed,completed,cancelled',
        ]);

        Flight::create($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight schedule created successfully!');
    }

    /**
     * Read: Show specific flight.
     */
    public function show(Flight $flight)
    {
        $flight->load(['reservations.user']);
        return view('admin.flights.show', compact('flight'));
    }

    /**
     * Update: Show edit form.
     */
    public function edit(Flight $flight)
    {
        return view('admin.flights.edit', compact('flight'));
    }

    /**
     * Update: Save edits.
     */
    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'airline' => 'required|string|max:100',
            'flight_number' => 'required|string|max:50|unique:flights,flight_number,' . $flight->id,
            'origin_city' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'origin_airport' => 'required|string|max:150',
            'destination_airport' => 'required|string|max:150',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'duration' => 'required|string|max:50',
            'seat_class' => 'required|in:Economy,Business,First Class',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:0',
            'price_per_seat' => 'required|numeric|min:0',
            'baggage_allowance' => 'nullable|string|max:100',
            'aircraft_type' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'status' => 'required|in:scheduled,delayed,completed,cancelled',
        ]);

        $flight->update($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight details updated successfully!');
    }

    /**
     * Delete: Delete flight.
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight schedule deleted successfully.');
    }
}
