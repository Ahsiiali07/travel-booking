@extends('layouts.app')

@section('title', 'Luxury Hotels & Resorts')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Partner Hotels & Resorts</h2>
            <p class="text-muted small">Stay at top-rated 4-star and 5-star properties across major travel destinations</p>
        </div>
        <a href="{{ route('search', ['tab' => 'hotels']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-sliders me-1"></i> Filter Hotels
        </a>
    </div>

    <div class="row g-4">
        @forelse($hotels as $hotel)
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div style="height: 220px; overflow: hidden; position: relative;">
                        <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $hotel->name }}">
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 px-2 py-1">
                                @for($i = 0; $i < $hotel->star_rating; $i++)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @endfor
                                <span class="ms-1 fw-bold">{{ $hotel->star_rating }}-Star</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="small text-muted mb-1">
                            <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->city }}, {{ $hotel->country }}
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $hotel->name }}</h5>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($hotel->description, 100) }}</p>

                        <!-- Room Types Badges -->
                        @if($hotel->room_types)
                            <div class="mb-3 d-flex flex-wrap gap-1">
                                @foreach(array_slice($hotel->room_types, 0, 2) as $type)
                                    <span class="badge bg-light text-secondary border small">{{ $type }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <div>
                                <span class="small text-muted">Per Night</span>
                                <div class="fw-extrabold text-primary fs-5">PKR {{ number_format($hotel->price_per_night) }}</div>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn-detail-figma">
                                    <i class="fa-regular fa-eye"></i> Details
                                </a>
                                <a href="{{ route('user.hotel-schedules.create', $hotel->id) }}" class="btn-book-figma">
                                    <i class="fa-solid fa-bed"></i> Book Room
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No hotels listed at the moment.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $hotels->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
