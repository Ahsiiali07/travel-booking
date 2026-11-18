@extends('layouts.app')

@section('title', 'Submit Refund Request')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-danger-subtle text-danger p-2 rounded-3"><i class="fa-solid fa-rotate-left fs-5"></i></div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0">Submit Refund Request</h4>
                        <div class="small text-muted">Request refund for paid and cancelled travel services</div>
                    </div>
                </div>

                <div class="alert alert-info small mb-4">
                    <i class="fa-solid fa-info-circle me-1"></i>
                    Refunds are subject to standard cancellation policies. Approved refunds will be reversed to your original payment method within 3 to 5 business days.
                </div>

                <form action="{{ route('user.refunds.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Eligible Paid Reservation <span class="text-danger">*</span></label>
                        <select name="reservation_id" id="reservation_id" class="form-select @error('reservation_id') is-invalid @enderror" required onchange="updateRefundAmount(this)">
                            <option value="">-- Choose Reservation --</option>
                            @foreach($eligibleReservations as $el)
                                <option value="{{ $el->id }}" data-amount="{{ $el->total_amount }}" {{ (isset($reservation) && $reservation->id == $el->id) ? 'selected' : '' }}>
                                    [{{ $el->booking_reference }}] {{ $el->item_name }} &bull; PKR {{ number_format($el->total_amount) }}
                                </option>
                            @endforeach
                        </select>
                        @error('reservation_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Refund Claim Amount</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">PKR</span>
                            <input type="text" id="display_amount" class="form-control bg-light" value="{{ isset($reservation) ? number_format($reservation->total_amount) : '0' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Preferred Refund Method <span class="text-danger">*</span></label>
                        <select name="refund_method" class="form-select" required>
                            <option value="original_payment_method">Original Payment Method (Card / Wallet)</option>
                            <option value="bank_account">Bank Account Transfer</option>
                            <option value="wallet_credit">Travel Credit / Voucher</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Reason for Cancellation / Refund <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4" required placeholder="Please explain why you are requesting a refund (minimum 10 characters)...">{{ old('reason') }}</textarea>
                        @error('reason')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('user.refunds.index') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to Refunds
                        </a>
                        <button type="submit" class="btn btn-danger py-2 px-4 fw-semibold">
                            <i class="fa-solid fa-paper-plane me-1"></i> Submit Refund Claim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateRefundAmount(select) {
    const selectedOption = select.options[select.selectedIndex];
    const amount = selectedOption.getAttribute('data-amount') || 0;
    document.getElementById('display_amount').value = Number(amount).toLocaleString();
}
</script>
@endsection
