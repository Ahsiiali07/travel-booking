@extends('layouts.app')

@section('title', 'Tour Voucher: ' . $reservation->booking_reference)

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        .tour-voucher-print, .tour-voucher-print * { visibility: visible; }
        .tour-voucher-print { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <a href="{{ route('user.package-bookings.index') }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to My Package Bookings
            </a>
            <h3 class="fw-bold text-dark mt-1 mb-0">Vacation Tour Booking Voucher</h3>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="fa-solid fa-print me-1"></i> Print Tour Voucher
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

    <div class="row justify-content-center tour-voucher-print">
        <div class="col-lg-9">
            <div class="card card-custom border-0 shadow-lg overflow-hidden">
                <div class="bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small text-white-50 fw-bold">Official Tour Confirmation</div>
                        <h3 class="fw-bold mb-0 text-white">{{ $reservation->package ? $reservation->package->name : 'Vacation Tour' }}</h3>
                        <div class="small text-white-50">
                            <i class="fa-solid fa-location-dot me-1 text-warning"></i> {{ $reservation->package?->destination }}, {{ $reservation->package?->country }}
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-primary fs-6 px-3 py-2 fw-bold">{{ strtoupper($reservation->status) }}</span>
                        <div class="small text-white-50 font-monospace mt-1">Ref: {{ $reservation->booking_reference }}</div>
                    </div>
                </div>

                <div class="p-4">
                    <!-- Key Tour Details Grid -->
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-md-3">
                            <div class="text-muted small text-uppercase fw-bold">Departure Date</div>
                            <h5 class="fw-bold text-dark mb-0">{{ $reservation->travel_date?->format('d M Y') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small text-uppercase fw-bold">Duration</div>
                            <h5 class="fw-bold text-dark mb-0">{{ $reservation->package?->duration_days }}D / {{ $reservation->package?->duration_nights }}N</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small text-uppercase fw-bold">Total Travelers</div>
                            <h5 class="fw-bold text-dark mb-0">{{ $reservation->guests_count }} Persons</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted small text-uppercase fw-bold">Payment Status</div>
                            <span class="badge {{ $reservation->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} text-uppercase">
                                {{ $reservation->payment_status }}
                            </span>
                        </div>
                    </div>

                    <!-- Passenger Manifest -->
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-users text-primary me-2"></i> Traveler Manifest</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm small mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Traveler Name</th>
                                    <th>CNIC / Passport</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($reservation->passenger_details))
                                    @foreach($reservation->passenger_details as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $p['name'] ?? 'N/A' }}</td>
                                            <td>{{ $p['cnic'] ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>1</td>
                                        <td class="fw-bold">{{ $reservation->contact_name }}</td>
                                        <td>N/A</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Daily Itinerary -->
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-route text-primary me-2"></i> Tour Itinerary</h6>
                    @if($reservation->package && $reservation->package->itinerary)
                        <div class="d-flex flex-column gap-2 mb-4">
                            @foreach($reservation->package->itinerary as $day)
                                <div class="p-2 border rounded-2 d-flex gap-3 align-items-center">
                                    <span class="badge bg-secondary">Day {{ $day['day'] ?? $loop->iteration }}</span>
                                    <span class="small text-muted">{{ $day['details'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Pricing Breakdown -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="small text-muted">
                            Lead Contact: <strong>{{ $reservation->contact_name }}</strong> ({{ $reservation->contact_phone }})
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Total Package Price</div>
                            <div class="fw-extrabold text-primary fs-4">PKR {{ number_format($reservation->total_amount) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
