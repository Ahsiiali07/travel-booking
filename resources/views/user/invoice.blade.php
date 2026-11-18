@extends('layouts.app')

@section('title', 'Invoice #' . $reservation->booking_reference)

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        .invoice-print-area, .invoice-print-area * { visibility: visible; }
        .invoice-print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
            </a>
            <h3 class="fw-bold text-dark mt-1 mb-0">Booking Invoice & Payment Receipt</h3>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn-detail-figma px-3">
                <i class="fa-solid fa-print me-1"></i> Print Invoice
            </button>
            @if($reservation->type === 'flight')
                <a href="{{ route('user.flight-schedules.show', $reservation->id) }}" class="btn btn-primary-custom btn-sm">
                    <i class="fa-solid fa-ticket me-1"></i> Boarding Pass
                </a>
            @elseif($reservation->type === 'hotel')
                <a href="{{ route('user.hotel-schedules.show', $reservation->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa-solid fa-hotel me-1"></i> Hotel Voucher
                </a>
            @else
                <a href="{{ route('user.package-bookings.show', $reservation->id) }}" class="btn btn-success btn-sm">
                    <i class="fa-solid fa-map-location-dot me-1"></i> Tour Voucher
                </a>
            @endif
        </div>
    </div>

    <div class="row justify-content-center invoice-print-area">
        <div class="col-lg-9">
            <div class="card card-custom border-0 shadow-lg p-5">
                <!-- Invoice Header -->
                <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-paper-plane text-primary fs-3"></i>
                            <h3 class="fw-extrabold text-primary mb-0">TravelBooking</h3>
                        </div>
                        <p class="text-muted small mb-0">
                            Travel Booking Services Pvt. Ltd.<br>
                            Islamabad, Pakistan &bull; NTN: 9812401-4<br>
                            Support: support@travelbooking.com
                        </p>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold text-dark mb-1">TAX INVOICE</h4>
                        <div class="font-monospace fw-bold text-primary">{{ $reservation->booking_reference }}</div>
                        <div class="small text-muted">Date: {{ $reservation->created_at->format('d M, Y') }}</div>
                        <span class="badge {{ $reservation->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} mt-1 text-uppercase">
                            {{ $reservation->payment_status }}
                        </span>
                    </div>
                </div>

                <!-- Billed To & Payment Details -->
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="text-muted small text-uppercase fw-bold mb-1">Billed Customer</div>
                        <h5 class="fw-bold text-dark mb-1">{{ $reservation->contact_name }}</h5>
                        <div class="small text-muted">{{ $reservation->contact_email }}</div>
                        <div class="small text-muted">{{ $reservation->contact_phone }}</div>
                        <div class="small text-muted">{{ $reservation->user?->address ?: 'Pakistan' }}</div>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <div class="text-muted small text-uppercase fw-bold mb-1">Payment Method & Reference</div>
                        <div class="fw-bold text-dark">{{ $reservation->payment ? ucwords(str_replace('_', ' ', $reservation->payment->payment_method)) : 'Online Payment' }}</div>
                        <div class="small font-monospace text-muted">Transaction ID: {{ $reservation->payment?->transaction_id ?: 'TXN-PENDING' }}</div>
                        <div class="small text-muted">Paid At: {{ $reservation->payment?->paid_at?->format('d M, Y h:i A') ?: 'Pending' }}</div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $reservation->item_name }}</div>
                                    <div class="small text-muted">
                                        @if($reservation->type === 'flight')
                                            Date: {{ $reservation->travel_date?->format('d M Y') }} &bull; Class: {{ $reservation->seat_class }}
                                        @elseif($reservation->type === 'hotel')
                                            Stay: {{ $reservation->check_in_date?->format('d M') }} to {{ $reservation->check_out_date?->format('d M Y') }} &bull; {{ $reservation->room_type }}
                                        @else
                                            Tour Departure: {{ $reservation->travel_date?->format('d M Y') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{ $reservation->type }}</span>
                                </td>
                                <td class="text-center">{{ $reservation->guests_count }} {{ Str::plural('Person', $reservation->guests_count) }}</td>
                                <td class="text-end fw-semibold">PKR {{ number_format($reservation->subtotal) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end border-0">Subtotal:</th>
                                <td class="text-end border-0">PKR {{ number_format($reservation->subtotal) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end border-0">Taxes & Fees:</th>
                                <td class="text-end border-0">+ PKR {{ number_format($reservation->tax_amount) }}</td>
                            </tr>
                            @if($reservation->discount_amount > 0)
                                <tr>
                                    <th colspan="3" class="text-end border-0 text-success">Discount:</th>
                                    <td class="text-end border-0 text-success">- PKR {{ number_format($reservation->discount_amount) }}</td>
                                </tr>
                            @endif
                            <tr class="table-light">
                                <th colspan="3" class="text-end fs-5">Grand Total:</th>
                                <th class="text-end fs-5 text-primary">PKR {{ number_format($reservation->total_amount) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Footer Note -->
                <div class="border-top pt-3 text-center small text-muted">
                    This is a computer-generated tax invoice and proof of booking payment. No signature required.<br>
                    Virtual University CS619 Final Year Project &bull; Supervisor: Sheikh Israr Ahmad
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
