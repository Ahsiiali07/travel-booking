@extends('layouts.app')

@section('title', $flight->airline . ' - ' . $flight->flight_number)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('flights.index') }}">Flights</a></li>
            <li class="breadcrumb-item active">{{ $flight->flight_number }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-custom p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <div>
                        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 mb-2">{{ $flight->seat_class }}</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ $flight->airline }}</h3>
                        <div class="text-muted small mt-1">Flight Number: <strong class="text-primary font-monospace">{{ $flight->flight_number }}</strong> &bull; Aircraft: {{ $flight->aircraft_type }}</div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $flight->status === 'scheduled' ? 'bg-success' : 'bg-warning' }} text-uppercase px-3 py-2">
                            {{ $flight->status }}
                        </span>
                    </div>
                </div>

                <!-- Flight Route Schedule Box -->
                <div class="bg-light p-4 rounded-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <span class="badge bg-secondary-subtle text-secondary small mb-1">ORIGIN</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $flight->origin_city }}</h4>
                            <p class="text-muted small mb-1">{{ $flight->origin_airport }}</p>
                            <div class="fw-semibold text-primary"><i class="fa-solid fa-clock me-1"></i> {{ $flight->departure_time->format('l, d F Y - h:i A') }}</div>
                        </div>
                        <div class="col-md-2 text-center py-3 py-md-0">
                            <div class="small text-muted fw-bold mb-1">{{ $flight->duration }}</div>
                            <div class="position-relative">
                                <hr class="border-primary border-2 my-0">
                                <i class="fa-solid fa-plane text-primary position-absolute top-50 start-50 translate-middle bg-light px-2 fs-5"></i>
                            </div>
                            <span class="badge bg-success-subtle text-success small mt-1">Direct Flight</span>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <span class="badge bg-secondary-subtle text-secondary small mb-1">DESTINATION</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $flight->destination_city }}</h4>
                            <p class="text-muted small mb-1">{{ $flight->destination_airport }}</p>
                            <div class="fw-semibold text-primary"><i class="fa-solid fa-clock me-1"></i> {{ $flight->arrival_time->format('l, d F Y - h:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Flight Specifications -->
                <h5 class="fw-bold text-dark mb-3">Flight Inclusions & Policies</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 d-flex align-items-center gap-3">
                            <div class="brand-icon-wrapper" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-suitcase"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Baggage Allowance</div>
                                <div class="text-muted small">{{ $flight->baggage_allowance }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 d-flex align-items-center gap-3">
                            <div class="brand-icon-wrapper" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-chair"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Available Seats</div>
                                <div class="text-success small fw-semibold">{{ $flight->available_seats }} of {{ $flight->total_seats }} Seats Open</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 d-flex align-items-center gap-3">
                            <div class="brand-icon-wrapper" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">In-Flight Service</div>
                                <div class="text-muted small">Complimentary meal & beverages included</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 d-flex align-items-center gap-3">
                            <div class="brand-icon-wrapper" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-rotate-left"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Refundable Ticket</div>
                                <div class="text-muted small">Easy cancellations with direct refund claim</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Sidebar Card -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 sticky-top" style="top: 100px;">
                <div class="text-muted small">Total Fare starting from</div>
                <div class="fw-extrabold text-primary display-6 mb-2">
                    PKR {{ number_format($flight->price_per_seat) }}
                    <span class="fs-6 text-muted fw-normal">/ seat</span>
                </div>
                <p class="small text-muted mb-4">Includes all mandatory airport taxes, seat assignment, and luggage allowance.</p>

                <div class="d-grid gap-2">
                    @auth
                        <a href="{{ route('user.flight-schedules.create', $flight->id) }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-calendar-plus me-1"></i> Schedule Flight Ticket
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Log In to Schedule Flight
                        </a>
                    @endauth
                    <a href="{{ route('flights.index') }}" class="btn btn-outline-secondary py-2">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Flights
                    </a>
                </div>

                <div class="border-top pt-3 mt-4 small text-muted">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-shield-check text-success"></i> Instant E-Ticket confirmation
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-headset text-primary"></i> 24/7 Travel Assistance
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
