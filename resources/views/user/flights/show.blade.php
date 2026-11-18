@extends('layouts.app')

@section('title', 'Flight Ticket: ' . $reservation->booking_reference)

@push('styles')
<style>
    .boarding-pass-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .boarding-pass-header {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: white;
        padding: 1.5rem 2rem;
    }
    .tear-line {
        border-top: 2px dashed #cbd5e1;
        position: relative;
        margin: 1.5rem 0;
    }
    .tear-line::before, .tear-line::after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: #f8fafc;
        border-radius: 50%;
        top: -12px;
    }
    .tear-line::before { left: -12px; }
    .tear-line::after { right: -12px; }

    @media print {
        body * { visibility: hidden; }
        .boarding-pass-print-area, .boarding-pass-print-area * { visibility: visible; }
        .boarding-pass-print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <a href="{{ route('user.flight-schedules.index') }}" class="text-decoration-none text-muted small">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to My Flight Schedules
            </a>
            <h3 class="fw-bold text-dark mt-1 mb-0">Electronic Flight Ticket & Boarding Pass</h3>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="fa-solid fa-print me-1"></i> Print Ticket
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

    <div class="row justify-content-center boarding-pass-print-area">
        <div class="col-lg-9">
            <div class="boarding-pass-card">
                <!-- Pass Header -->
                <div class="boarding-pass-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small tracking-wider opacity-75">Boarding Pass & E-Ticket</div>
                        <h4 class="fw-bold mb-0">{{ $reservation->flight ? $reservation->flight->airline : 'Airline Reservation' }}</h4>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white text-primary px-3 py-2 fw-bold fs-6">{{ $reservation->seat_class ?: 'Economy' }}</span>
                        <div class="small opacity-75 mt-1 font-monospace">{{ $reservation->booking_reference }}</div>
                    </div>
                </div>

                <!-- Pass Body -->
                <div class="p-4">
                    <!-- Route -->
                    <div class="row align-items-center mb-4">
                        <div class="col-5">
                            <span class="text-muted small text-uppercase">Departure Airport</span>
                            <h3 class="fw-extrabold text-dark mb-0">{{ $reservation->flight?->origin_city }}</h3>
                            <div class="small text-muted">{{ $reservation->flight?->origin_airport }}</div>
                            <div class="badge bg-primary-subtle text-primary mt-2">
                                <i class="fa-solid fa-calendar me-1"></i> {{ $reservation->travel_date?->format('d M Y') }} &bull; {{ $reservation->flight?->departure_time->format('h:i A') }}
                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <i class="fa-solid fa-plane fs-3 text-primary"></i>
                            <div class="small text-muted mt-1">{{ $reservation->flight?->duration }}</div>
                        </div>
                        <div class="col-5 text-end">
                            <span class="text-muted small text-uppercase">Arrival Airport</span>
                            <h3 class="fw-extrabold text-dark mb-0">{{ $reservation->flight?->destination_city }}</h3>
                            <div class="small text-muted">{{ $reservation->flight?->destination_airport }}</div>
                            <div class="badge bg-primary-subtle text-primary mt-2">
                                <i class="fa-solid fa-clock me-1"></i> {{ $reservation->flight?->arrival_time->format('h:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Meta Grid -->
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-3">
                            <span class="text-muted small d-block">Flight No.</span>
                            <strong class="text-dark">{{ $reservation->flight?->flight_number }}</strong>
                        </div>
                        <div class="col-3">
                            <span class="text-muted small d-block">Aircraft</span>
                            <strong class="text-dark">{{ $reservation->flight?->aircraft_type ?: 'Airbus A320' }}</strong>
                        </div>
                        <div class="col-3">
                            <span class="text-muted small d-block">Baggage</span>
                            <strong class="text-dark">{{ $reservation->flight?->baggage_allowance ?: '20 KG' }}</strong>
                        </div>
                        <div class="col-3">
                            <span class="text-muted small d-block">Booking Status</span>
                            <span class="badge {{ $reservation->status === 'confirmed' ? 'bg-success' : 'bg-warning' }} text-uppercase">
                                {{ $reservation->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Passenger Roster -->
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-users me-1 text-primary"></i> Passenger Manifest ({{ count($reservation->passenger_details ?? []) ?: 1 }})</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm small mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Passenger Name</th>
                                    <th>CNIC / Passport</th>
                                    <th>Assigned Seat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($reservation->passenger_details))
                                    @foreach($reservation->passenger_details as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $p['name'] ?? 'N/A' }}</td>
                                            <td>{{ $p['cnic'] ?? 'N/A' }}</td>
                                            <td><span class="badge bg-dark">{{ $p['seat'] ?? ($reservation->seat_class . '-' . rand(10, 30) . 'C') }}</span></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>1</td>
                                        <td class="fw-bold">{{ $reservation->contact_name }}</td>
                                        <td>N/A</td>
                                        <td><span class="badge bg-dark">{{ $reservation->seat_class }}-12A</span></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="tear-line"></div>

                    <!-- Barcode / Ticket Footer -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Primary Contact: <strong>{{ $reservation->contact_name }}</strong> ({{ $reservation->contact_phone }})</div>
                            <div class="small text-muted">Total Fare: <strong>PKR {{ number_format($reservation->total_amount) }}</strong> &bull; Payment: <strong class="text-success text-uppercase">{{ $reservation->payment_status }}</strong></div>
                        </div>
                        <div class="text-center font-monospace mt-2 mt-md-0">
                            <div class="bg-dark text-white px-3 py-1 rounded small letter-spacing-2">||| | ||||| || |||||| | ||| ||||</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ $reservation->booking_reference }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
