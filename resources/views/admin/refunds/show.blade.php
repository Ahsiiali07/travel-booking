@extends('layouts.admin')

@section('title', 'Refund Details #' . $refund->refund_reference)
@section('page_title', 'Refund Inspection')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.refunds.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Refunds List
    </a>
    <a href="{{ route('admin.refunds.edit', $refund->id) }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-pen-to-square me-1"></i> Update Refund Status
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <span class="text-muted small">REFUND CLAIM</span>
                    <h3 class="fw-bold font-monospace text-danger mb-0">{{ $refund->refund_reference }}</h3>
                </div>
                <div>
                    @if($refund->status === 'processed')
                        <span class="badge bg-success fs-6 px-3 py-2">Processed</span>
                    @elseif($refund->status === 'approved')
                        <span class="badge bg-info fs-6 px-3 py-2">Approved</span>
                    @elseif($refund->status === 'rejected')
                        <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                    @else
                        <span class="badge bg-warning fs-6 px-3 py-2">Pending</span>
                    @endif
                </div>
            </div>

            <!-- Details Grid -->
            <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                <div class="col-sm-4">
                    <span class="text-muted small d-block">Claimed Amount</span>
                    <strong class="text-dark fs-5">PKR {{ number_format($refund->amount) }}</strong>
                </div>
                <div class="col-sm-4">
                    <span class="text-muted small d-block">Refund Channel</span>
                    <strong class="text-dark">{{ ucwords(str_replace('_', ' ', $refund->refund_method)) }}</strong>
                </div>
                <div class="col-sm-4">
                    <span class="text-muted small d-block">Submission Date</span>
                    <strong class="text-dark">{{ $refund->created_at->format('d M, Y h:i A') }}</strong>
                </div>
            </div>

            <!-- Associated Booking -->
            <h6 class="fw-bold text-dark mb-2">Associated Reservation Details</h6>
            <div class="p-3 border rounded-3 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-dark">{{ $refund->reservation?->item_name ?: 'Reservation' }}</div>
                        <div class="small text-muted font-monospace">Ref: {{ $refund->reservation?->booking_reference }}</div>
                        <div class="small text-muted">Customer: {{ $refund->user?->name }} ({{ $refund->user?->email }})</div>
                    </div>
                    @if($refund->reservation)
                        <a href="{{ route('admin.reservations.show', $refund->reservation->id) }}" class="btn btn-sm btn-outline-primary">
                            View Reservation
                        </a>
                    @endif
                </div>
            </div>

            <!-- Reason & Remarks -->
            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-1">Customer Reason for Claim</h6>
                <div class="p-3 bg-light rounded-3 small text-muted">
                    {{ $refund->reason }}
                </div>
            </div>

            <div>
                <h6 class="fw-bold text-dark mb-1">Administrator Remarks & Audit Notes</h6>
                <div class="p-3 border rounded-3 small text-muted bg-white">
                    {{ $refund->admin_remarks ?: 'No administrator remarks recorded yet.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
