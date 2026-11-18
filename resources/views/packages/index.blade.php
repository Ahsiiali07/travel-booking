@extends('layouts.app')

@section('title', 'Curated Vacation Packages')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Curated Vacation Packages</h2>
            <p class="text-muted small">All-inclusive holiday plans covering hotels, guided tours, transport, and flights</p>
        </div>
        <a href="{{ route('search', ['tab' => 'packages']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="fa-solid fa-sliders me-1"></i> Filter Tours
        </a>
    </div>

    <div class="row g-4">
        @forelse($packages as $pkg)
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom h-100">
                    <div style="height: 220px; overflow: hidden; position: relative;">
                        <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $pkg->name }}">
                        @if($pkg->is_featured)
                            <span class="badge bg-warning position-absolute top-0 start-0 m-3 fw-bold">FEATURED</span>
                        @endif
                        @if($pkg->discount_percent > 0)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3 fw-bold">{{ $pkg->discount_percent }}% OFF</span>
                        @endif
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-muted border">
                                <i class="fa-solid fa-clock text-primary me-1"></i> {{ $pkg->duration_days }} Days / {{ $pkg->duration_nights }} Nights
                            </span>
                            <span class="small text-muted">
                                <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $pkg->destination }}
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $pkg->name }}</h5>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($pkg->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <div>
                                <span class="small text-muted">Starting from</span>
                                <div class="fw-extrabold text-primary fs-5">
                                    PKR {{ number_format($pkg->final_price) }}
                                    @if($pkg->discount_percent > 0)
                                        <span class="text-muted text-decoration-line-through small fs-6">PKR {{ number_format($pkg->price) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('packages.show', $pkg->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Details</a>
                                <a href="{{ route('user.package-bookings.create', $pkg->id) }}" class="btn btn-sm btn-primary-custom">Book Tour</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No vacation packages found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $packages->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
