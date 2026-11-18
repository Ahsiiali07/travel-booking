@extends('layouts.app')

@section('title', 'Scheduled Flights')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-1">Scheduled Flights</h2>
            <p class="text-muted small mb-0">Browse domestic and international airlines with instant seat reservations</p>
        </div>
        <a href="{{ route('search', ['tab' => 'flights']) }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
            <i class="fa-solid fa-sliders me-1"></i> Advanced Filter
        </a>
    </div>

    <!-- Quick Airport Filter Bar -->
    <div class="card card-custom border-0 p-3 p-md-4 mb-4 bg-white shadow-sm">
        <form action="{{ route('flights.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <x-airport-select 
                    name="origin" 
                    id="index_flight_origin" 
                    label="From (City / Code)" 
                    value="{{ request('origin') }}" 
                    placeholder="e.g. Karachi, Islamabad" 
                    icon="fa-plane" 
                    iconColor="#0084c7"
                    badgeBg="#e0f2fe"
                    badgeColor="#0084c7"
                />
            </div>
            <div class="col-md-4">
                <x-airport-select 
                    name="destination" 
                    id="index_flight_dest" 
                    label="To (City / Code)" 
                    value="{{ request('destination') }}" 
                    placeholder="e.g. Skardu, Dubai" 
                    icon="fa-plane-arrival" 
                    iconColor="#0084c7"
                    badgeBg="#e0f2fe"
                    badgeColor="#0084c7"
                />
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted mb-1"><i class="fa-solid fa-chair text-primary me-1"></i> Cabin Class</label>
                <select name="class" class="form-select">
                    <option value="">All Classes</option>
                    <option value="Economy" {{ request('class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                    <option value="Business" {{ request('class') == 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="First Class" {{ request('class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="fa-solid fa-magnifying-glass me-1"></i> Filter</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        @forelse($flights as $flight)
            <div class="col-lg-6">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="brand-icon-wrapper" style="width: 44px; height: 44px; font-size: 1.15rem;">
                                <i class="fa-solid fa-plane"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $flight->airline }}</h5>
                                <span class="badge bg-primary-subtle text-primary font-monospace fw-bold small">{{ $flight->flight_number }}</span>
                                <span class="badge bg-light text-secondary border small ms-1">{{ $flight->seat_class }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Fare per seat</div>
                            <div class="fw-extrabold text-primary fs-4">PKR {{ number_format($flight->price_per_seat) }}</div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-3 my-3">
                        <div class="row align-items-center text-center g-2">
                            <div class="col-4 text-start">
                                <div class="fw-bold fs-5 text-dark">{{ $flight->origin_city }}</div>
                                <div class="small text-muted text-truncate">{{ $flight->origin_airport }}</div>
                                <div class="badge bg-white text-dark border mt-1">{{ $flight->departure_time->format('d M, h:i A') }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted small mb-1">{{ $flight->duration }}</div>
                                <div class="position-relative">
                                    <hr class="my-0 border-primary">
                                    <i class="fa-solid fa-plane text-primary position-absolute top-50 start-50 translate-middle bg-light px-1"></i>
                                </div>
                                <div class="small text-success mt-1 fw-semibold">Non-stop</div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="fw-bold fs-5 text-dark">{{ $flight->destination_city }}</div>
                                <div class="small text-muted text-truncate">{{ $flight->destination_airport }}</div>
                                <div class="badge bg-white text-dark border mt-1">{{ $flight->arrival_time->format('d M, h:i A') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 gap-2">
                        <div class="small text-muted">
                            <i class="fa-solid fa-suitcase-rolling me-1 text-secondary"></i> {{ $flight->baggage_allowance }}
                            <span class="mx-2 d-none d-sm-inline">&bull;</span>
                            <span class="text-success fw-semibold"><i class="fa-solid fa-chair me-1"></i> {{ $flight->available_seats }} seats open</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Details</a>
                            <a href="{{ route('user.flight-schedules.create', $flight->id) }}" class="btn btn-sm btn-primary-custom">Schedule Now</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-plane-slash fs-1 text-muted mb-2"></i>
                <p class="text-muted">No scheduled flights matching criteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $flights->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
