<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Read: List all refunds.
     */
    public function index(Request $request)
    {
        $query = Refund::with(['reservation.user', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('refund_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('reservation', function($rq) use ($search) {
                      $rq->where('booking_reference', 'like', "%{$search}%");
                  });
            });
        }

        $refunds = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.refunds.index', compact('refunds'));
    }

    /**
     * Create: Show manual refund creation form.
     */
    public function create()
    {
        $paidReservations = Reservation::with('user')
            ->where('payment_status', 'paid')
            ->doesntHave('refund')
            ->get();

        return view('admin.refunds.create', compact('paidReservations'));
    }

    /**
     * Create: Store manual refund.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,processed,rejected',
            'refund_method' => 'required|string|max:50',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $reservation = Reservation::findOrFail($validated['reservation_id']);

        $refund = Refund::create([
            'refund_reference' => Refund::generateReference(),
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
            'status' => $validated['status'],
            'refund_method' => $validated['refund_method'],
            'admin_remarks' => $validated['admin_remarks'],
            'processed_at' => in_array($validated['status'], ['approved', 'processed']) ? now() : null,
        ]);

        if ($validated['status'] === 'processed') {
            $reservation->update(['payment_status' => 'refunded', 'status' => 'cancelled']);
        }

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund record #' . $refund->refund_reference . ' created successfully.');
    }

    /**
     * Read: Show refund details.
     */
    public function show(Refund $refund)
    {
        $refund->load(['reservation.user', 'reservation.flight', 'reservation.hotel', 'reservation.package', 'reservation.payment', 'user']);
        return view('admin.refunds.show', compact('refund'));
    }

    /**
     * Update: Show edit form.
     */
    public function edit(Refund $refund)
    {
        $refund->load(['reservation.user']);
        return view('admin.refunds.edit', compact('refund'));
    }

    /**
     * Update: Save edited refund status and remarks.
     */
    public function update(Request $request, Refund $refund)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,processed,rejected',
            'amount' => 'required|numeric|min:0',
            'refund_method' => 'required|string|max:50',
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        if ($validated['status'] === 'processed' && $refund->status !== 'processed') {
            $validated['processed_at'] = now();
            // Update reservation status
            if ($refund->reservation) {
                $refund->reservation->update([
                    'payment_status' => 'refunded',
                    'status' => 'cancelled',
                ]);
            }
        }

        $refund->update($validated);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund #' . $refund->refund_reference . ' status updated to ' . ucfirst($validated['status']) . '.');
    }

    /**
     * Delete: Delete refund record.
     */
    public function destroy(Refund $refund)
    {
        $ref = $refund->refund_reference;
        $refund->delete();

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund record #' . $ref . ' has been deleted.');
    }
}
