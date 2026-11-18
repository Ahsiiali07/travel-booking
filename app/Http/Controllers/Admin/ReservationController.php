<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Read: Display listing of reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'flight', 'hotel', 'package', 'payment', 'refund']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Read: Show specific reservation details.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'flight', 'hotel', 'package', 'payment', 'refund']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show edit form for reservation.
     */
    public function edit(Reservation $reservation)
    {
        $reservation->load(['user', 'flight', 'hotel', 'package']);
        return view('admin.reservations.edit', compact('reservation'));
    }

    /**
     * Update: Update reservation status and payment status.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,pending,cancelled,completed',
            'payment_status' => 'required|in:unpaid,paid,refunded,partial_refund',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation #' . $reservation->booking_reference . ' updated successfully.');
    }

    /**
     * Delete: Remove reservation record.
     */
    public function destroy(Reservation $reservation)
    {
        $ref = $reservation->booking_reference;
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation #' . $ref . ' has been deleted.');
    }
}
