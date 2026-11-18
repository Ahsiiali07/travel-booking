@extends('layouts.app')

@section('title', $hotel->name)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
            <li class="breadcrumb-item active">{{ $hotel->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-custom border-0 overflow-hidden mb-4">
                <div style="height: 380px; overflow: hidden;">
                    <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $hotel->name }}">
                </div>

                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="mb-1">
                                @for($i = 0; $i < $hotel->star_rating; $i++)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @endfor
                                <span class="badge bg-warning-subtle text-dark ms-2">{{ $hotel->star_rating }}-Star Luxury Property</span>
                            </div>
                            <h2 class="fw-bold text-dark mb-1">{{ $hotel->name }}</h2>
                            <div class="text-muted small">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success fs-6 px-3 py-2">
                            <i class="fa-solid fa-bed me-1"></i> {{ $hotel->available_rooms }} Rooms Available
                        </span>
                    </div>

                    <h5 class="fw-bold text-dark mt-4 mb-2">About the Property</h5>
                    <p class="text-muted leading-relaxed">{{ $hotel->description }}</p>

                    <!-- Amenities -->
                    <h5 class="fw-bold text-dark mt-4 mb-3">Hotel Amenities & Services</h5>
                    <div class="row g-3">
                        @if($hotel->amenities)
                            @foreach($hotel->amenities as $amenity)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-3">
                                        <i class="fa-solid fa-circle-check text-primary"></i>
                                        <span class="small fw-semibold text-dark">{{ $amenity }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12"><p class="text-muted small">Standard 5-star amenities included.</p></div>
                        @endif
                    </div>

                    <!-- Available Room Types -->
                    <h5 class="fw-bold text-dark mt-4 mb-3">Available Room Types</h5>
                    <div class="row g-3">
                        @if($hotel->room_types)
                            @foreach($hotel->room_types as $type)
                                <div class="col-md-4">
                                    <div class="p-3 border rounded-3 text-center">
                                        <i class="fa-solid fa-door-open fs-3 text-secondary mb-2"></i>
                                        <div class="fw-bold text-dark small">{{ $type }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">En-suite bathroom & AC</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Box Sidebar -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 sticky-top" style="top: 100px;">
                <div class="text-muted small">Price starts at</div>
                <div class="fw-extrabold text-primary display-6 mb-1">
                    PKR {{ number_format($hotel->price_per_night) }}
                    <span class="fs-6 text-muted fw-normal">/ night</span>
                </div>
                <div class="small text-muted mb-4">+ 8% standard hospitality tax included at checkout.</div>

                <div class="d-grid gap-2">
                    @auth
                        <a href="{{ route('user.hotel-schedules.create', $hotel->id) }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-calendar-check me-1"></i> Book Hotel Stay
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-custom py-2">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Log In to Book Room
                        </a>
                    @endauth
                    <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary py-2">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Hotels
                    </a>
                </div>

                <div class="border-top pt-3 mt-4 small">
                    <div class="d-flex align-items-center gap-2 mb-2 text-muted">
                        <i class="fa-solid fa-phone text-primary"></i> Front Desk: <strong>{{ $hotel->contact_phone ?: '+92-51-1112223' }}</strong>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <i class="fa-solid fa-envelope text-primary"></i> Email: <strong>{{ $hotel->contact_email ?: 'support@travelbooking.com' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
