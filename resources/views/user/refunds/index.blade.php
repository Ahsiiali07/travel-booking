@extends('layouts.app')

@section('title', 'My Refund Requests')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Refund Requests</h2>
            <p class="text-muted small">Track status of refunds for cancelled flights, hotels, and vacation packages</p>
        </div>
        <a href="{{ route('user.refunds.create') }}" class="btn btn-primary-custom btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Request New Refund
        </a>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Refund Ref</th>
                        <th>Booking Ref</th>
                        <th>Service Item</th>
                        <th>Claimed Amount</th>
                        <th>Reason for Refund</th>
                        <th>Refund Status</th>
                        <th>Admin Remarks</th>
                        <th class="text-end pe-4">Date Requested</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($refunds as $refund)
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-primary">{{ $refund->refund_reference }}</td>
                            <td>
                                @if($refund->reservation)
                                    <span class="badge bg-secondary-subtle text-secondary font-monospace">{{ $refund->reservation->booking_reference }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $refund->reservation?->item_name ?: 'Travel Reservation' }}</div>
                            </td>
                            <td class="fw-bold text-dark">PKR {{ number_format($refund->amount) }}</td>
                            <td>
                                <div class="small text-muted" style="max-width: 250px;">{{ Str::limit($refund->reason, 80) }}</div>
                            </td>
                            <td>
                                @if($refund->status === 'processed')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check-double me-1"></i> Processed</span>
                                @elseif($refund->status === 'approved')
                                    <span class="badge bg-info-subtle text-info"><i class="fa-solid fa-check me-1"></i> Approved</span>
                                @elseif($refund->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-clock me-1"></i> Pending Review</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $refund->admin_remarks ?: 'Under administrator evaluation.' }}
                            </td>
                            <td class="text-end pe-4 small text-muted">
                                {{ $refund->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-rotate-left fs-2 text-muted mb-2"></i>
                                <p class="mb-0">You have no active refund requests.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $refunds->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
