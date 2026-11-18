<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show Checkout Page.
     */
    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->payment_status === 'paid') {
            return redirect()->route('user.invoice', $reservation->id)
                ->with('info', 'This reservation is already paid. Here is your receipt.');
        }

        $reservation->load(['flight', 'hotel', 'package']);

        return view('user.checkout', compact('reservation'));
    }

    /**
     * Process Payment & Complete Checkout.
     */
    public function process(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->payment_status === 'paid') {
            return redirect()->route('user.invoice', $reservation->id);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,easypaisa,jazzcash,bank_transfer',
            'card_holder_name' => 'required_if:payment_method,credit_card,debit_card|nullable|string|max:255',
            'card_number' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'expiry_month' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'expiry_year' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'cvv' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'mobile_account_number' => 'required_if:payment_method,easypaisa,jazzcash|nullable|string',
            'bank_ref_number' => 'required_if:payment_method,bank_transfer|nullable|string',
        ]);

        $cardLastFour = null;
        if (in_array($validated['payment_method'], ['credit_card', 'debit_card']) && !empty($validated['card_number'])) {
            $digits = preg_replace('/\D/', '', $validated['card_number']);
            $cardLastFour = substr($digits, -4) ?: '4242';
        } elseif (!empty($validated['mobile_account_number'])) {
            $cardLastFour = substr($validated['mobile_account_number'], -4);
        }

        // Record payment
        $payment = Payment::create([
            'transaction_id' => Payment::generateTransactionId(),
            'reservation_id' => $reservation->id,
            'user_id' => Auth::id(),
            'amount' => $reservation->total_amount,
            'payment_method' => $validated['payment_method'],
            'card_holder_name' => $validated['card_holder_name'] ?? Auth::user()->name,
            'card_last_four' => $cardLastFour,
            'status' => 'successful',
            'paid_at' => now(),
        ]);

        // Update reservation status
        $reservation->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        return redirect()->route('user.invoice', $reservation->id)
            ->with('success', 'Payment successful! Your reservation has been confirmed.');
    }

    /**
     * Show / Print Invoice.
     */
    public function invoice(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $reservation->load(['user', 'flight', 'hotel', 'package', 'payment', 'refund']);

        return view('user.invoice', compact('reservation'));
    }

    /**
     * List all payments for current user.
     */
    public function paymentHistory()
    {
        $payments = Payment::with('reservation')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.payments.index', compact('payments'));
    }
}
