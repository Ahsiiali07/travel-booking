<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageBookingController extends Controller
{
    /**
     * Read: Display all booked packages for the user.
     */
    public function index()
    {
        $packageBookings = Reservation::with(['package.hotel', 'package.flight', 'payment', 'refund'])
            ->where('user_id', Auth::id())
            ->where('type', 'package')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.packages.index', compact('packageBookings'));
    }

    /**
     * Book: Show booking form for a vacation package.
     */
    public function create(Package $package)
    {
        if ($package->available_slots <= 0) {
            return back()->with('error', 'Sorry, this tour package is currently sold out.');
        }

        return view('user.packages.create', compact('package'));
    }

    /**
     * Book: Store the vacation package booking.
     */
    public function store(Request $request, Package $package)
    {
        $validated = $request->validate([
            'travel_date' => 'required|date|after_or_equal:today',
            'travelers_count' => 'required|integer|min:1|max:20',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:30',
            'passenger_names' => 'required|array|min:1',
            'passenger_names.*' => 'required|string|max:255',
            'passenger_cnics' => 'nullable|array',
            'passenger_cnics.*' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string|max:500',
        ]);

        if ($package->available_slots < $validated['travelers_count']) {
            return back()->with('error', 'Not enough available slots for this tour.');
        }

        // Price calculation with package discount
        $unitPrice = $package->final_price;
        $subtotal = $unitPrice * $validated['travelers_count'];
        $tax = round($subtotal * 0.05, 2);
        $total = $subtotal + $tax;

        $passengers = [];
        foreach ($validated['passenger_names'] as $index => $name) {
            $passengers[] = [
                'name' => $name,
                'cnic' => $validated['passenger_cnics'][$index] ?? 'N/A',
            ];
        }

        $reservation = Reservation::create([
            'booking_reference' => Reservation::generateReference(),
            'user_id' => Auth::id(),
            'type' => 'package',
            'package_id' => $package->id,
            'hotel_id' => $package->hotel_id,
            'flight_id' => $package->flight_id,
            'travel_date' => $validated['travel_date'],
            'guests_count' => $validated['travelers_count'],
            'contact_name' => $validated['contact_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'passenger_details' => $passengers,
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'discount_amount' => round(($package->price * ($package->discount_percent / 100)) * $validated['travelers_count'], 2),
            'total_amount' => $total,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        $package->decrement('available_slots', $validated['travelers_count']);

        return redirect()->route('user.checkout', $reservation->id)
            ->with('success', 'Vacation package booked! Please finalize payment to confirm your trip.');
    }

    /**
     * Read: Show specific package booking details and itinerary.
     */
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['package.hotel', 'package.flight', 'payment', 'refund']);

        return view('user.packages.show', compact('reservation'));
    }

    /**
     * Delete: Cancel specific package booking.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->type !== 'package') {
            return back()->with('error', 'Invalid package booking.');
        }

        if ($reservation->package) {
            $reservation->package->increment('available_slots', $reservation->guests_count);
        }

        if ($reservation->payment_status === 'paid') {
            $reservation->update(['status' => 'cancelled']);
            return redirect()->route('user.refunds.create', ['reservation_id' => $reservation->id])
                ->with('info', 'Package booking cancelled. You can now submit a refund request for your payment.');
        }

        $reservation->delete();

        return redirect()->route('user.package-bookings.index')
            ->with('success', 'Package booking has been cancelled.');
    }
}
