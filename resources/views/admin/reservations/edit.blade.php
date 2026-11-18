@extends('layouts.admin')

@section('title', 'Update Reservation #' . $reservation->booking_reference)
@section('page_title', 'Update Reservation Status')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Update Reservation: {{ $reservation->booking_reference }}</h5>
                    <div class="small text-muted">{{ $reservation->item_name }} &bull; Customer: {{ $reservation->contact_name }}</div>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-bold">Reservation Booking Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $reservation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" class="form-select" required>
                        <option value="paid" {{ $reservation->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ $reservation->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="refunded" {{ $reservation->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        <option value="partial_refund" {{ $reservation->payment_status === 'partial_refund' ? 'selected' : '' }}>Partial Refund</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Administrator / Special Requests Notes</label>
                    <textarea name="special_requests" class="form-control" rows="3">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Reservation Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
