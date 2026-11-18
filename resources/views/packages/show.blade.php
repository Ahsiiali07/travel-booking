@extends('layouts.app')

@section('title', $package->name)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Vacation Packages</a></li>
            <li class="breadcrumb-item active">{{ $package->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-custom border-0 overflow-hidden mb-4">
                <div style="height: 400px; overflow: hidden; position: relative;">
                    <img src="{{ $package->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $package->name }}">
                    @if($package->discount_percent > 0)
                        <span class="badge bg-danger position-absolute top-0 end-0 m-3 fs-6 p-2">{{ $package->discount_percent }}% SPECIAL DISCOUNT</span>
                    @endif
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-1">
                                <i class="fa-solid fa-clock me-1"></i> {{ $package->duration_days }} Days &bull; {{ $package->duration_nights }} Nights
                            </span>
                            <h2 class="fw-bold text-dark mb-1">{{ $package->name }}</h2>
                            <div class="text-muted small">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $package->destination }}, {{ $package->country }}
                            </div>
                        </div>
                        <span class="badge bg-info-subtle text-info fs-6 px-3 py-2">
                            <i class="fa-solid fa-users me-1"></i> {{ $package->available_slots }} Slots Open
                        </span>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-2">Package Overview</h5>
                    <p class="text-muted leading-relaxed">{{ $package->description }}</p>

                    <!-- Included Components -->
                    <div class="row g-3 my-3">
                        @if($package->hotel)
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-hotel text-primary me-1"></i> Accommodation</div>
                                    <div class="fw-bold text-dark mt-1">{{ $package->hotel->name }}</div>
                                    <div class="small text-muted">{{ $package->hotel->star_rating }}-Star in {{ $package->hotel->city }}</div>
                                </div>
                            </div>
                        @endif
                        @if($package->flight)
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="text-muted small fw-bold text-uppercase"><i class="fa-solid fa-plane text-primary me-1"></i> Included Airline</div>
                                    <div class="fw-bold text-dark mt-1">{{ $package->flight->airline }} ({{ $package->flight->flight_number }})</div>
                                    <div class="small text-muted">{{ $package->flight->origin_city }} &rarr; {{ $package->flight->destination_city }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Daily Itinerary -->
                    <h5 class="fw-bold text-dark mt-4 mb-3"><i class="fa-solid fa-route text-primary me-2"></i> Day-by-Day Itinerary</h5>
                    <div class="timeline">
                        @if($package->itinerary)
                            <div class="d-flex flex-column gap-3">
                                @foreach($package->itinerary as $day)
                                    <div class="p-3 rounded-3 border bg-white shadow-sm d-flex gap-3 align-items-start">
                                        <div class="badge bg-primary text-white p-2 rounded-2" style="min-width: 65px; text-align: center;">
                                            Day {{ $day['day'] ?? $loop->iteration }}
                                        </div>
                                        <div>
                                            <p class="mb-0 text-dark small fw-medium">{{ $day['details'] ?? 'Scenic tour and local exploration.' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small">Detailed itinerary provided upon booking confirmation.</p>
                        @endif
                    </div>

                    <!-- Inclusions & Exclusions -->
                    <div class="row g-4 mt-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-success mb-3"><i class="fa-solid fa-circle-check me-2"></i> What's Included</h6>
                            <ul class="list-unstyled small text-muted d-flex flex-column gap-2">
                                @if($package->inclusions)
                                    @foreach($package->inclusions as $inc)
                                        <li class="d-flex align-items-center gap-2"><i class="fa-solid fa-check text-success"></i> {{ $inc }}</li>
                                    @endforeach
                                @else
                                    <li>Hotel Stay & Breakfast</li>
                                    <li>Transportation & Sightseeing</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-circle-xmark me-2"></i> What's Excluded</h6>
                            <ul class="list-unstyled small text-muted d-flex flex-column gap-2">
                                @if($package->exclusions)
                                    @foreach($package->exclusions as $exc)
                                        <li class="d-flex align-items-center gap-2"><i class="fa-solid fa-xmark text-danger"></i> {{ $exc }}</li>
                                    @endforeach
                                @else
                                    <li>Personal shopping & tips</li>
                                    <li>Extra meals not specified</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Sidebar -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 sticky-top" style="top: 100px;">
                <div class="text-muted small">Package Price per person</div>
                <div class="fw-extrabold text-primary display-6 mb-1">
                    PKR {{ number_format($package->final_price) }}
                    @if($package->discount_percent > 0)
                        <span class="fs-6 text-muted text-decoration-line-through fw-normal">PKR {{ number_format($package->price) }}</span>
                    @endif
                </div>
                <div class="small text-muted mb-4">Includes hotels, guided transportation, and meals as specified.</div>

                <div class="d-grid gap-2">
                    @auth
                        <a href="{{ route('user.package-bookings.create', $package->id) }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-calendar-check me-1"></i> Book This Vacation Package
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Log In to Book Package
                        </a>
                    @endauth
                    <a href="{{ route('packages.index') }}" class="btn-detail-figma py-2 justify-content-center">
                        <i class="fa-solid fa-arrow-left me-1"></i> Explore More Packages
                    </a>
                </div>

                <div class="border-top pt-3 mt-4 small text-muted">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-award text-warning"></i> Best Price Guarantee
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-shield-halved text-success"></i> 100% Secure Checkout
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-headset text-primary"></i> 24/7 Tour Coordination Support
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
