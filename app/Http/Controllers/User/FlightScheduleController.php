<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightScheduleController extends Controller
{
    /**
     * Read: Display user's scheduled flights.
     */
    public function index()
    {
        $flightSchedules = Reservation::with(['flight', 'payment', 'refund'])
            ->where('user_id', Auth::id())
            ->where('type', 'flight')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.flights.index', compact('flightSchedules'));
    }

    /**
     * Create: Show booking form for a specific flight schedule.
     */
    public function create(Flight $flight)
    {
        if ($flight->available_seats <= 0) {
            return back()->with('error', 'Sorry, this flight is fully booked.');
        }

        return view('user.flights.create', compact('flight'));
    }

    /**
     * Create: Store the scheduled flight reservation.
     */
    public function store(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'travel_date' => 'required|date|after_or_equal:today',
            'passengers_count' => 'required|integer|min:1|max:10',
            'seat_class' => 'required|string|in:Economy,Business,First Class',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:30',
            'passenger_names' => 'required|array|min:1',
            'passenger_names.*' => 'required|string|max:255',
            'passenger_cnics' => 'nullable|array',
            'passenger_cnics.*' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string|max:500',
        ]);

        if ($flight->available_seats < $validated['passengers_count']) {
            return back()->with('error', 'Not enough available seats for this flight.');
        }

        // Calculate pricing
        $multiplier = match ($validated['seat_class']) {
            'Business' => 1.5,
            'First Class' => 2.0,
            default => 1.0,
        };

        $basePrice = $flight->price_per_seat * $multiplier * $validated['passengers_count'];
        $tax = round($basePrice * 0.05, 2); // 5% airport tax
        $totalAmount = $basePrice + $tax;

        // Build passenger list
        $passengers = [];
        foreach ($validated['passenger_names'] as $index => $name) {
            $passengers[] = [
                'name' => $name,
                'cnic' => $validated['passenger_cnics'][$index] ?? 'N/A',
                'seat' => $validated['seat_class'] . '-' . rand(1, 35) . chr(rand(65, 70)),
            ];
        }

        $reservation = Reservation::create([
            'booking_reference' => Reservation::generateReference(),
            'user_id' => Auth::id(),
            'type' => 'flight',
            'flight_id' => $flight->id,
            'travel_date' => $validated['travel_date'],
            'guests_count' => $validated['passengers_count'],
            'seat_class' => $validated['seat_class'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'passenger_details' => $passengers,
            'subtotal' => $basePrice,
            'tax_amount' => $tax,
            'discount_amount' => 0.00,
            'total_amount' => $totalAmount,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        // Decrement available seats
        $flight->decrement('available_seats', $validated['passengers_count']);

        return redirect()->route('user.checkout', $reservation->id)
            ->with('success', 'Flight schedule created! Please complete payment to confirm your ticket.');
    }

    /**
     * Read: Show specific flight ticket & boarding pass.
     */
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['flight', 'payment', 'refund']);

        return view('user.flights.show', compact('reservation'));
    }

    /**
     * Delete: Cancel specific flight schedule.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->type !== 'flight') {
            return back()->with('error', 'Invalid flight reservation.');
        }

        // Restore available flight seats
        if ($reservation->flight) {
            $reservation->flight->increment('available_seats', $reservation->guests_count);
        }

        // If reservation is already paid, keep record but mark status cancelled and redirect to refund
        if ($reservation->payment_status === 'paid') {
            $reservation->update(['status' => 'cancelled']);
            return redirect()->route('user.refunds.create', ['reservation_id' => $reservation->id])
                ->with('info', 'Flight schedule cancelled. You can now submit a refund request for your payment.');
        }

        // If unpaid, delete the reservation
        $reservation->delete();

        return redirect()->route('user.flight-schedules.index')
            ->with('success', 'Flight schedule has been cancelled and removed.');
    }
}
