@extends('layouts.app')

@section('title', 'Checkout & Payment - ' . $reservation->booking_reference)

@section('content')
<div class="container py-4">
    <div class="row g-4 justify-content-center">
        <!-- Payment Options Form (Left) -->
        <div class="col-lg-7">
            <div class="card card-custom p-4 border-0 shadow-sm mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-success-subtle text-success p-2 rounded-3"><i class="fa-solid fa-lock fs-5"></i></div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Secure Checkout & Payment</h4>
                        <div class="small text-muted">256-bit Encrypted Transaction Gateway Simulation</div>
                    </div>
                </div>

                <!-- 1-Click Test Card Fill Button for Viva Demo -->
                <div class="alert alert-light border small d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-secondary me-1">Testing Card</span>
                        <code>4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242</code> (CVV: 123)
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="fillTestCard()">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto Fill Test Card
                    </button>
                </div>

                <form action="{{ route('user.checkout.pay', $reservation->id) }}" method="POST" id="checkoutForm">
                    @csrf
                    <label class="form-label small fw-bold text-uppercase text-muted mb-2">Select Payment Method</label>
                    <div class="row g-2 mb-4">
                        <div class="col-6 col-md-3">
                            <input type="radio" class="btn-check" name="payment_method" id="pay_card" value="credit_card" checked onchange="togglePaymentFields('card')">
                            <label class="btn btn-outline-primary w-100 py-3 text-center rounded-3 h-100 d-flex flex-column align-items-center justify-content-center" for="pay_card">
                                <i class="fa-solid fa-credit-card fs-4 mb-1"></i>
                                <span class="small fw-bold">Card</span>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" class="btn-check" name="payment_method" id="pay_easypaisa" value="easypaisa" onchange="togglePaymentFields('mobile')">
                            <label class="btn btn-outline-success w-100 py-3 text-center rounded-3 h-100 d-flex flex-column align-items-center justify-content-center" for="pay_easypaisa">
                                <i class="fa-solid fa-mobile-screen fs-4 mb-1"></i>
                                <span class="small fw-bold">Easypaisa</span>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" class="btn-check" name="payment_method" id="pay_jazzcash" value="jazzcash" onchange="togglePaymentFields('mobile')">
                            <label class="btn btn-outline-danger w-100 py-3 text-center rounded-3 h-100 d-flex flex-column align-items-center justify-content-center" for="pay_jazzcash">
                                <i class="fa-solid fa-wallet fs-4 mb-1"></i>
                                <span class="small fw-bold">JazzCash</span>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="radio" class="btn-check" name="payment_method" id="pay_bank" value="bank_transfer" onchange="togglePaymentFields('bank')">
                            <label class="btn btn-outline-secondary w-100 py-3 text-center rounded-3 h-100 d-flex flex-column align-items-center justify-content-center" for="pay_bank">
                                <i class="fa-solid fa-building-columns fs-4 mb-1"></i>
                                <span class="small fw-bold">Bank</span>
                            </label>
                        </div>
                    </div>

                    <!-- Credit / Debit Card Fields -->
                    <div id="cardFields">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Cardholder Name</label>
                            <input type="text" name="card_holder_name" id="card_holder_name" class="form-control" value="{{ auth()->user()->name }}" placeholder="Name printed on card">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Card Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-brands fa-cc-visa text-primary"></i></span>
                                <input type="text" name="card_number" id="card_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <label class="form-label small fw-semibold">Exp Month</label>
                                <select name="expiry_month" id="expiry_month" class="form-select">
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ sprintf('%02d', $m) }}">{{ sprintf('%02d', $m) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label small fw-semibold">Exp Year</label>
                                <select name="expiry_year" id="expiry_year" class="form-select">
                                    @for($y=date('Y'); $y<=date('Y')+7; $y++)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label small fw-semibold">CVV</label>
                                <input type="password" name="cvv" id="cvv" class="form-control" placeholder="123" maxlength="4">
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Wallet Fields -->
                    <div id="mobileFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Mobile Wallet Account Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="mobile_account_number" id="mobile_account_number" class="form-control" placeholder="0300 1234567">
                            </div>
                            <div class="form-text small">An instant OTP prompt will be sent to your mobile wallet app.</div>
                        </div>
                    </div>

                    <!-- Bank Transfer Fields -->
                    <div id="bankFields" style="display: none;">
                        <div class="alert alert-secondary small mb-3">
                            <strong>Bank Account:</strong> Habib Bank Limited (HBL)<br>
                            <strong>Account Title:</strong> TravelBooking Services Pvt. Ltd.<br>
                            <strong>IBAN:</strong> PK36HABB0001234567890123
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Transaction / Deposit Reference Number</label>
                            <input type="text" name="bank_ref_number" class="form-control" placeholder="e.g. HBL-FT-9812450">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-6">
                            <i class="fa-solid fa-shield-check me-2"></i> Confirm Payment of PKR {{ number_format($reservation->total_amount) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary (Right) -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 border-0 shadow-sm sticky-top" style="top: 100px;">
                <h5 class="fw-bold text-dark mb-3">Booking Summary</h5>

                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-3">
                    <div class="bg-primary text-white p-2 rounded-2">
                        @if($reservation->type === 'flight')
                            <i class="fa-solid fa-plane"></i>
                        @elseif($reservation->type === 'hotel')
                            <i class="fa-solid fa-hotel"></i>
                        @else
                            <i class="fa-solid fa-umbrella-beach"></i>
                        @endif
                    </div>
                    <div>
                        <span class="badge bg-secondary-subtle text-secondary small text-uppercase">{{ $reservation->type }}</span>
                        <div class="fw-bold text-dark">{{ $reservation->item_name }}</div>
                        <div class="small text-muted font-monospace">{{ $reservation->booking_reference }}</div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 small text-muted border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Lead Customer:</span>
                        <strong class="text-dark">{{ $reservation->contact_name }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Service Date:</span>
                        <strong class="text-dark">
                            @if($reservation->type === 'hotel')
                                {{ $reservation->check_in_date?->format('d M') }} - {{ $reservation->check_out_date?->format('d M Y') }}
                            @else
                                {{ $reservation->travel_date?->format('d M Y') }}
                            @endif
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Guests / Travelers:</span>
                        <strong class="text-dark">{{ $reservation->guests_count }} Persons</strong>
                    </div>
                </div>

                <!-- Financial Breakdown -->
                <div class="d-flex flex-column gap-2 small mb-3">
                    <div class="d-flex justify-content-between text-muted">
                        <span>Subtotal:</span>
                        <span>PKR {{ number_format($reservation->subtotal) }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted">
                        <span>Taxes & Processing:</span>
                        <span>+ PKR {{ number_format($reservation->tax_amount) }}</span>
                    </div>
                    @if($reservation->discount_amount > 0)
                        <div class="d-flex justify-content-between text-success">
                            <span>Promotional Discount:</span>
                            <span>- PKR {{ number_format($reservation->discount_amount) }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between fw-bold text-dark fs-5 pt-2 border-top">
                        <span>Total Payable:</span>
                        <span class="text-primary">PKR {{ number_format($reservation->total_amount) }}</span>
                    </div>
                </div>

                <div class="small text-muted text-center pt-2">
                    <i class="fa-solid fa-lock text-success me-1"></i> Your information is protected by industry standard encryption.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePaymentFields(type) {
    document.getElementById('cardFields').style.display = (type === 'card') ? 'block' : 'none';
    document.getElementById('mobileFields').style.display = (type === 'mobile') ? 'block' : 'none';
    document.getElementById('bankFields').style.display = (type === 'bank') ? 'block' : 'none';
}

function fillTestCard() {
    document.getElementById('pay_card').checked = true;
    togglePaymentFields('card');
    document.getElementById('card_number').value = '4242 4242 4242 4242';
    document.getElementById('card_holder_name').value = '{{ auth()->user()->name }}';
    document.getElementById('cvv').value = '123';
}
</script>
@endsection
