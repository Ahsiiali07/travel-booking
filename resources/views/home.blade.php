@extends('layouts.app')

@section('title', 'Explore the World & Book Your Next Journey')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(9, 13, 22, 0.78) 0%, rgba(17, 24, 39, 0.85) 60%, rgba(79, 70, 229, 0.4) 100%),
                    url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
        padding: 4.5rem 0 5.5rem;
        color: #ffffff;
        position: relative;
    }

    .hero-search-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        padding: 1.75rem;
        margin-top: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .hero-search-card .nav-pills {
        gap: 0.5rem;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 0.5rem;
        scrollbar-width: none;
    }

    .hero-search-card .nav-pills::-webkit-scrollbar {
        display: none;
    }

    .hero-search-card .nav-pills .nav-link {
        font-weight: 700;
        font-size: 0.95rem;
        color: #64748b;
        border-radius: 14px;
        padding: 0.75rem 1.4rem;
        white-space: nowrap;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .hero-search-card .nav-pills .nav-link:hover {
        background: #f1f5f9;
        color: var(--primary) !important;
    }

    .hero-search-card .nav-pills .nav-link.active {
        background: var(--accent-gradient);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }

    .card-img-wrapper {
        height: 210px;
        overflow: hidden;
        position: relative;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-custom:hover .card-img-wrapper img {
        transform: scale(1.08);
    }

    .package-badge-discount {
        position: absolute;
        top: 14px;
        right: 14px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-weight: 800;
        padding: 0.35rem 0.75rem;
        border-radius: 10px;
        font-size: 0.75rem;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }

    .package-badge-featured {
        position: absolute;
        top: 14px;
        left: 14px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        font-weight: 800;
        padding: 0.35rem 0.75rem;
        border-radius: 10px;
        font-size: 0.75rem;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease;
    }

    .stat-pill:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.12);
    }

    /* Mobile specific adjustments */
    @media (max-width: 767.98px) {
        .hero-section {
            padding: 3rem 0 4rem;
        }
        .hero-search-card {
            padding: 1.25rem;
            border-radius: 20px;
        }
        .hero-search-card .nav-pills .nav-link {
            padding: 0.6rem 1rem;
            font-size: 0.88rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center text-md-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9 mx-auto text-center">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-white text-dark small fw-semibold shadow-sm">
                    <span class="badge bg-primary">NEW</span> Book Top Domestic Flights, Luxury Hotels & Holiday Tours
                </div>
                <h1 class="display-4 fw-extrabold text-white mb-3 tracking-tight">
                    Travel Pakistan & Beyond With Confidence
                </h1>
                <p class="lead text-light opacity-90 mb-4 px-md-5">
                    Search scheduled flights across Pakistan airports, book luxury 5-star hotels, and reserve handpicked holiday packages with instant confirmation.
                </p>

                <!-- Quick Stats Row -->
                <div class="row g-2 g-md-3 justify-content-center mt-3">
                    <div class="col-6 col-md-3">
                        <div class="stat-pill text-center">
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['total_packages'] }}+</h3>
                            <div class="small text-light opacity-75">Tour Packages</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-pill text-center">
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['total_flights'] }}+</h3>
                            <div class="small text-light opacity-75">Scheduled Flights</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-pill text-center">
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['total_hotels'] }}+</h3>
                            <div class="small text-light opacity-75">Partner Hotels</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-pill text-center">
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['happy_travelers'] }}+</h3>
                            <div class="small text-light opacity-75">Happy Travelers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Universal Multi-Tab Search Card -->
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div class="hero-search-card">
                    <ul class="nav nav-pills mb-3 border-bottom pb-2" id="searchTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link" id="packages-tab" data-bs-toggle="pill" data-bs-target="#tab-packages" type="button">
                                <i class="fa-solid fa-umbrella-beach me-1"></i> Vacation Packages
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link active" id="flights-tab" data-bs-toggle="pill" data-bs-target="#tab-flights" type="button">
                                <i class="fa-solid fa-plane me-1"></i> Flights
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="hotels-tab" data-bs-toggle="pill" data-bs-target="#tab-hotels" type="button">
                                <i class="fa-solid fa-hotel me-1"></i> Hotels
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="searchTabsContent">
                        <!-- Tab 1: Flights (With Pakistan Airports Search Dropdowns) -->
                        <div class="tab-pane fade show active" id="tab-flights">
                            <form action="{{ route('search') }}" method="GET" class="row g-3 align-items-end">
                                <input type="hidden" name="tab" value="flights">
                                
                                <div class="col-12 col-md-4">
                                    <x-airport-select 
                                        name="origin" 
                                        id="home_flight_origin" 
                                        label="From (City / Code)" 
                                        placeholder="e.g. Karachi, Islamabad" 
                                        icon="fa-plane" 
                                    />
                                </div>

                                <div class="col-12 col-md-4">
                                    <x-airport-select 
                                        name="destination" 
                                        id="home_flight_dest" 
                                        label="To (City / Code)" 
                                        placeholder="e.g. Skardu, Dubai" 
                                        icon="fa-plane-arrival" 
                                    />
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="form-label small fw-bold text-muted mb-1 d-flex align-items-center gap-1">
                                        <i class="fa-solid fa-calendar-day text-primary"></i> Departure Date
                                    </label>
                                    <input type="date" name="flight_date" class="form-control fw-semibold" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="col-12 col-md-2">
                                    <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search Flights
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2: Vacation Packages -->
                        <div class="tab-pane fade" id="tab-packages">
                            <form action="{{ route('search') }}" method="GET" class="row g-3 align-items-end">
                                <input type="hidden" name="tab" value="packages">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted mb-1">
                                        <i class="fa-solid fa-location-dot text-primary me-1"></i> Destination or Tour Name
                                    </label>
                                    <input type="text" name="package_destination" class="form-control" placeholder="e.g. Hunza, Skardu, Murree, Dubai">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-1">
                                        <i class="fa-solid fa-calendar-days text-primary me-1"></i> Max Duration (Days)
                                    </label>
                                    <select name="duration" class="form-select">
                                        <option value="">Any Duration</option>
                                        <option value="3">Up to 3 Days</option>
                                        <option value="5">Up to 5 Days</option>
                                        <option value="7">Up to 7 Days</option>
                                        <option value="10">Up to 10 Days</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search Packages
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 3: Hotels -->
                        <div class="tab-pane fade" id="tab-hotels">
                            <form action="{{ route('search') }}" method="GET" class="row g-3 align-items-end">
                                <input type="hidden" name="tab" value="hotels">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted mb-1">
                                        <i class="fa-solid fa-city text-primary me-1"></i> City or Hotel Name
                                    </label>
                                    <input type="text" name="hotel_city" class="form-control" placeholder="e.g. Islamabad, Lahore, Hunza, Skardu">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-1">
                                        <i class="fa-solid fa-star text-warning me-1"></i> Minimum Rating
                                    </label>
                                    <select name="star_rating" class="form-select">
                                        <option value="">Any Star Rating</option>
                                        <option value="5">5 Stars Luxury</option>
                                        <option value="4">4 Stars & Above</option>
                                        <option value="3">3 Stars & Above</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search Hotels
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scheduled Flights Showcase -->
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-soft-primary text-uppercase px-3 py-1 mb-2">Non-Stop & Direct</span>
                <h2 class="fw-bold text-dark mb-0">Scheduled Domestic & International Flights</h2>
            </div>
            <a href="{{ route('flights.index') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
                Explore All Flights <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($popularFlights as $flight)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-custom h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary font-monospace fw-bold px-2 py-1">{{ $flight->flight_number }}</span>
                            <span class="badge bg-light text-dark border">{{ $flight->seat_class }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $flight->airline }}</h5>
                        <div class="small text-muted mb-3">{{ $flight->aircraft_type }}</div>

                        <!-- Route visual -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light mb-3">
                            <div class="text-start">
                                <div class="fw-extrabold fs-5 text-dark">{{ $flight->origin_city }}</div>
                                <div class="text-muted small">{{ $flight->departure_time->format('h:i A') }}</div>
                            </div>
                            <div class="text-center px-2">
                                <i class="fa-solid fa-plane text-primary"></i>
                                <div class="small text-muted" style="font-size: 0.72rem;">{{ $flight->duration }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-extrabold fs-5 text-dark">{{ $flight->destination_city }}</div>
                                <div class="text-muted small">{{ $flight->arrival_time->format('h:i A') }}</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                            <div>
                                <span class="small text-muted">Per Seat</span>
                                <div class="fw-bold text-dark fs-5">PKR {{ number_format($flight->price_per_seat) }}</div>
                            </div>
                            <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-sm btn-outline-custom rounded-pill px-3">
                                Schedule Flight
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No scheduled flights available right now.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Vacation Packages -->
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-soft-cyan text-uppercase px-3 py-1 mb-2">Curated Escapes</span>
                <h2 class="fw-bold text-dark mb-0">Featured Vacation Packages</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
                View All Packages <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredPackages as $pkg)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom h-100">
                        <div class="card-img-wrapper">
                            <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $pkg->name }}">
                            @if($pkg->is_featured)
                                <span class="package-badge-featured"><i class="fa-solid fa-fire me-1"></i> FEATURED</span>
                            @endif
                            @if($pkg->discount_percent > 0)
                                <span class="package-badge-discount">{{ $pkg->discount_percent }}% OFF</span>
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-muted border">
                                    <i class="fa-solid fa-clock me-1 text-primary"></i> {{ $pkg->duration_days }}D / {{ $pkg->duration_nights }}N
                                </span>
                                <span class="small text-muted">
                                    <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $pkg->destination }}
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $pkg->name }}</h5>
                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit($pkg->description, 95) }}
                            </p>

                            <div class="border-top pt-3 d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <div class="small text-muted">From</div>
                                    <div class="fw-extrabold text-primary fs-5">
                                        PKR {{ number_format($pkg->final_price) }}
                                        @if($pkg->discount_percent > 0)
                                            <span class="text-muted text-decoration-line-through small fs-6">PKR {{ number_format($pkg->price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('packages.show', $pkg->id) }}" class="btn btn-sm btn-primary-custom">
                                    View Details <i class="fa-solid fa-angle-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No vacation packages currently available.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Top Rated Hotels -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-soft-warning text-uppercase px-3 py-1 mb-2">Comfort & Hospitality</span>
                <h2 class="fw-bold text-dark mb-0">Popular Hotels & Resorts</h2>
            </div>
            <a href="{{ route('hotels.index') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
                Browse All Hotels <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($topHotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom h-100">
                        <div class="card-img-wrapper">
                            <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $hotel->name }}">
                            <div class="position-absolute bottom-0 start-0 m-3">
                                @for($i = 0; $i < $hotel->star_rating; $i++)
                                    <i class="fa-solid fa-star text-warning small"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="small text-muted mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->city }}, {{ $hotel->country }}</span>
                            <h5 class="fw-bold text-dark mb-2">{{ $hotel->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($hotel->description, 90) }}</p>

                            <div class="border-top pt-3 d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <div class="small text-muted">Per Night</div>
                                    <div class="fw-bold text-dark fs-5">PKR {{ number_format($hotel->price_per_night) }}</div>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-sm btn-outline-custom rounded-pill px-3">
                                    Book Room
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No hotel listings found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CS619 FYP Supervisor & Project Info Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge bg-primary text-uppercase px-3 py-1 mb-2 font-monospace">CS619 Final Year Project</span>
                <h3 class="fw-bold mb-2">Travel Booking Application using MVC-based Framework</h3>
                <p class="text-light opacity-80 mb-0 leading-relaxed">
                    Built strictly adhering to the Model-View-Controller (MVC) architectural pattern in Laravel 12. Features full CRUD management, complete database migrations, foreign-key relationships, transactional checkout simulation, and comprehensive administration.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="p-3 bg-secondary bg-opacity-25 rounded-3 border border-secondary text-start">
                    <div class="fw-bold text-info small mb-1"><i class="fa-solid fa-user-tie me-1"></i> Project Supervisor</div>
                    <div class="fw-bold fs-6">Sheikh Israr Ahmad</div>
                    <div class="small text-light opacity-80">Virtual University of Pakistan</div>
                    <div class="small text-light opacity-80"><i class="fa-solid fa-envelope me-1"></i> israr.ahmad@vu.edu.pk</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
