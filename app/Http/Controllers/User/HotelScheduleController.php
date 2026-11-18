<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelScheduleController extends Controller
{
    /**
     * Read: Display user's scheduled hotel reservations.
     */
    public function index()
    {
        $hotelSchedules = Reservation::with(['hotel', 'payment', 'refund'])
            ->where('user_id', Auth::id())
            ->where('type', 'hotel')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.hotels.index', compact('hotelSchedules'));
    }

    /**
     * Create: Show booking form for a specific hotel schedule.
     */
    public function create(Hotel $hotel)
    {
        if ($hotel->available_rooms <= 0) {
            return back()->with('error', 'Sorry, this hotel has no available rooms at the moment.');
        }

        return view('user.hotels.create', compact('hotel'));
    }

    /**
     * Create: Store the scheduled hotel stay reservation.
     */
    public function store(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_type' => 'required|string',
            'guests_count' => 'required|integer|min:1|max:20',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:500',
        ]);

        if ($hotel->available_rooms <= 0) {
            return back()->with('error', 'No rooms currently available in this hotel.');
        }

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        if ($nights < 1) $nights = 1;

        $roomMultiplier = str_contains(strtolower($validated['room_type']), 'suite') ? 1.4 : 1.0;
        $subtotal = $hotel->price_per_night * $nights * $roomMultiplier;
        $tax = round($subtotal * 0.08, 2); // 8% hospitality tax
        $total = $subtotal + $tax;

        $reservation = Reservation::create([
            'booking_reference' => Reservation::generateReference(),
            'user_id' => Auth::id(),
            'type' => 'hotel',
            'hotel_id' => $hotel->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests_count' => $validated['guests_count'],
            'room_type' => $validated['room_type'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'discount_amount' => 0.00,
            'total_amount' => $total,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        $hotel->decrement('available_rooms', 1);

        return redirect()->route('user.checkout', $reservation->id)
            ->with('success', 'Hotel schedule booked! Please complete payment to confirm your stay.');
    }

    /**
     * Read: Show specific hotel voucher.
     */
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['hotel', 'payment', 'refund']);

        return view('user.hotels.show', compact('reservation'));
    }

    /**
     * Delete: Cancel specific hotel schedule.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->type !== 'hotel') {
            return back()->with('error', 'Invalid hotel reservation.');
        }

        if ($reservation->hotel) {
            $reservation->hotel->increment('available_rooms', 1);
        }

        if ($reservation->payment_status === 'paid') {
            $reservation->update(['status' => 'cancelled']);
            return redirect()->route('user.refunds.create', ['reservation_id' => $reservation->id])
                ->with('info', 'Hotel reservation cancelled. You can now submit a refund request for your payment.');
        }

        $reservation->delete();

        return redirect()->route('user.hotel-schedules.index')
            ->with('success', 'Hotel reservation has been cancelled.');
    }
}
