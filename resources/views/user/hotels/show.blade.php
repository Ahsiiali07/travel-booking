@extends('layouts.app')

@section('title', 'Hotel Voucher: ' . $reservation->booking_reference)

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        .voucher-print-area, .voucher-print-area * { visibility: visible; }
        .voucher-print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <a href="{{ route('user.hotel-schedules.index') }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to My Hotel Schedules
            </a>
            <h3 class="fw-bold text-dark mt-1 mb-0">Hotel Check-in Stay Voucher</h3>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="fa-solid fa-print me-1"></i> Print Voucher
            </button>
            @if($reservation->payment_status === 'paid')
                <a href="{{ route('user.invoice', $reservation->id) }}" class="btn btn-primary-custom btn-sm">
                    <i class="fa-solid fa-receipt me-1"></i> View Receipt
                </a>
            @else
                <a href="{{ route('user.checkout', $reservation->id) }}" class="btn btn-success btn-sm">
                    <i class="fa-solid fa-credit-card me-1"></i> Pay Now (PKR {{ number_format($reservation->total_amount) }})
                </a>
            @endif
        </div>
    </div>

    <div class="row justify-content-center voucher-print-area">
        <div class="col-lg-9">
            <div class="card card-custom border-0 shadow-lg overflow-hidden">
                <div class="bg-dark text-white p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small text-warning fw-bold">Official Booking Voucher</div>
                        <h3 class="fw-bold mb-0 text-white">{{ $reservation->hotel ? $reservation->hotel->name : 'Hotel Reservation' }}</h3>
                        <div class="small text-light opacity-75">
                            <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $reservation->hotel?->address }}, {{ $reservation->hotel?->city }}
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 fw-bold">{{ $reservation->status === 'confirmed' ? 'CONFIRMED' : strtoupper($reservation->status) }}</span>
                        <div class="small text-light font-monospace mt-1">Ref: {{ $reservation->booking_reference }}</div>
                    </div>
                </div>

                <div class="p-4">
                    <!-- Stay Dates Grid -->
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4 text-center">
                        <div class="col-md-4 text-md-start">
                            <div class="text-muted small text-uppercase fw-bold">Check-In Date</div>
                            <h4 class="fw-bold text-dark mb-0">{{ $reservation->check_in_date?->format('d M Y') }}</h4>
                            <div class="small text-muted">From 02:00 PM onwards</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small text-uppercase fw-bold">Duration of Stay</div>
                            <h5 class="fw-bold text-primary mb-0">
                                {{ $reservation->check_in_date && $reservation->check_out_date ? $reservation->check_in_date->diffInDays($reservation->check_out_date) : 1 }} Night(s)
                            </h5>
                            <div class="small text-muted">{{ $reservation->room_type }}</div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="text-muted small text-uppercase fw-bold">Check-Out Date</div>
                            <h4 class="fw-bold text-dark mb-0">{{ $reservation->check_out_date?->format('d M Y') }}</h4>
                            <div class="small text-muted">Until 12:00 PM noon</div>
                        </div>
                    </div>

                    <!-- Guest & Room Details -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-user text-primary me-2"></i> Lead Guest Details</h6>
                            <div class="p-3 border rounded-3">
                                <div><strong>Name:</strong> {{ $reservation->contact_name }}</div>
                                <div><strong>Email:</strong> {{ $reservation->contact_email }}</div>
                                <div><strong>Phone:</strong> {{ $reservation->contact_phone }}</div>
                                <div><strong>Total Guests:</strong> {{ $reservation->guests_count }} Persons</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-bell-concierge text-primary me-2"></i> Special Preferences & Requests</h6>
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <p class="small text-muted mb-0">
                                    {{ $reservation->special_requests ?: 'No special requests submitted at time of booking.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Hotel Contact & Check-in Rules -->
                    <div class="alert alert-info small mb-4">
                        <div class="fw-bold mb-1"><i class="fa-solid fa-circle-info me-1"></i> Check-in Instructions:</div>
                        Please present an original valid Government CNIC / Passport and this booking voucher upon arrival at the front desk. For late arrivals or airport shuttle requests, contact the property at <strong>{{ $reservation->hotel?->contact_phone ?: '+92-51-2874000' }}</strong>.
                    </div>

                    <!-- Pricing Summary -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div>
                            <span class="text-muted small">Payment Status:</span>
                            <span class="badge {{ $reservation->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} text-uppercase ms-1">
                                {{ $reservation->payment_status }}
                            </span>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Total Paid Amount</div>
                            <div class="fw-extrabold text-primary fs-4">PKR {{ number_format($reservation->total_amount) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
