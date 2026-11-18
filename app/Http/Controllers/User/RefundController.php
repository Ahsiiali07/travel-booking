<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    /**
     * Display all refund requests submitted by the user.
     */
    public function index()
    {
        $refunds = Refund::with('reservation')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.refunds.index', compact('refunds'));
    }

    /**
     * Show form to request a refund for a paid/cancelled reservation.
     */
    public function create(Request $request)
    {
        $reservationId = $request->get('reservation_id');
        $reservation = null;

        if ($reservationId) {
            $reservation = Reservation::where('user_id', Auth::id())
                ->where('id', $reservationId)
                ->where('payment_status', 'paid')
                ->firstOrFail();

            if ($reservation->refund) {
                return redirect()->route('user.refunds.index')
                    ->with('info', 'A refund request for this reservation has already been submitted.');
            }
        }

        $eligibleReservations = Reservation::where('user_id', Auth::id())
            ->where('payment_status', 'paid')
            ->doesntHave('refund')
            ->get();

        return view('user.refunds.create', compact('reservation', 'eligibleReservations'));
    }

    /**
     * Store refund request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'reason' => 'required|string|min:10|max:1000',
            'refund_method' => 'required|string|max:50',
        ]);

        $reservation = Reservation::where('user_id', Auth::id())
            ->where('id', $validated['reservation_id'])
            ->where('payment_status', 'paid')
            ->firstOrFail();

        if ($reservation->refund) {
            return back()->with('error', 'Refund request already submitted for this reservation.');
        }

        // Create refund request
        $refund = Refund::create([
            'refund_reference' => Refund::generateReference(),
            'reservation_id' => $reservation->id,
            'user_id' => Auth::id(),
            'amount' => $reservation->total_amount,
            'reason' => $validated['reason'],
            'refund_method' => $validated['refund_method'],
            'status' => 'pending',
        ]);

        // Update reservation status to cancelled if not already
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('user.refunds.index')
            ->with('success', 'Refund request #' . $refund->refund_reference . ' submitted successfully! Admin will review it shortly.');
    }
}
