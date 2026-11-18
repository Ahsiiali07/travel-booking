@extends('layouts.app')

@section('title', 'My Payment History')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Payment & Transaction History</h2>
            <p class="text-muted small">View all online payments, card records, and download official invoices</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Transaction ID</th>
                        <th>Booking Ref</th>
                        <th>Service Description</th>
                        <th>Payment Method</th>
                        <th>Amount Paid</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-dark">{{ $payment->transaction_id }}</td>
                            <td>
                                @if($payment->reservation)
                                    <span class="badge bg-primary-subtle text-primary font-monospace">{{ $payment->reservation->booking_reference }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $payment->reservation?->item_name ?: 'Travel Service Booking' }}</div>
                                <span class="badge bg-light text-muted border text-uppercase">{{ $payment->reservation?->type }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-credit-card text-muted"></i>
                                    <span class="small">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                    @if($payment->card_last_four)
                                        <span class="small text-muted font-monospace">(**** {{ $payment->card_last_four }})</span>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold text-dark">PKR {{ number_format($payment->amount) }}</td>
                            <td class="small text-muted">{{ $payment->paid_at?->format('d M, Y h:i A') ?: $payment->created_at->format('d M, Y') }}</td>
                            <td>
                                @if($payment->status === 'successful')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check me-1"></i> Successful</span>
                                @elseif($payment->status === 'refunded')
                                    <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-rotate-left me-1"></i> Refunded</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($payment->reservation)
                                    <a href="{{ route('user.invoice', $payment->reservation->id) }}" class="btn-detail-figma py-1 px-3">
                                        <i class="fa-solid fa-file-invoice me-1"></i> Invoice
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-receipt fs-2 text-muted mb-2"></i>
                                <p class="mb-0">No payment transactions recorded yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $payments->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
