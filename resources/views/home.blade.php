@extends('layouts.app')

@section('title', 'Go Where You Feel Most Alive')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(180deg, rgba(7, 25, 43, 0.78) 0%, rgba(7, 25, 43, 0.55) 50%, rgba(7, 25, 43, 0.85) 100%),
                    url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=2000&q=85') center/cover no-repeat;
        padding: 5rem 0 6rem;
        color: #ffffff;
        position: relative;
    }

    .hero-kicker-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        padding: 0.45rem 1.1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #ffffff;
    }

    .hero-dot-gold {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ffb64d;
        display: inline-block;
    }

    .hero-title {
        font-family: 'Manrope', sans-serif;
        font-size: clamp(2.4rem, 5.2vw, 4.3rem);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -0.04em;
        color: #ffffff;
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
    }

    /* Floating Search Card matching Figma / User Reference Screenshot */
    .hero-search-card {
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 25px 65px -15px rgba(0, 0, 0, 0.38), 0 10px 25px -5px rgba(0, 0, 0, 0.18);
        padding: 2rem 2.2rem;
        margin: 2.5rem auto 0;
        max-width: 590px;
        border: 1px solid rgba(255, 255, 255, 0.95);
        text-align: left;
    }

    .hero-search-card .nav-pills {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        padding: 0;
    }

    .hero-search-card .nav-pills .nav-item {
        flex: 1;
        text-align: center;
    }

    .hero-search-card .nav-pills .nav-link {
        font-weight: 700;
        font-size: 0.95rem;
        color: #334155;
        border-radius: 14px;
        padding: 0.65rem 1.1rem;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        background: transparent;
    }

    .hero-search-card .nav-pills .nav-link:hover {
        background: #f0f9ff;
        color: #0084c7 !important;
    }

    .hero-search-card .nav-pills .nav-link.active {
        background-color: #0084c7 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(0, 132, 199, 0.35);
    }

    .search-card-divider {
        border-top: 1px solid #e2e8f0;
        margin: 0.85rem 0 1.5rem;
        opacity: 0.9;
    }

    .search-input-clean {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        height: 48px;
        background-color: #ffffff;
        color: #1e293b;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-input-clean:focus {
        border-color: #0084c7;
        box-shadow: 0 0 0 3px rgba(0, 132, 199, 0.16);
        outline: none;
    }

    .btn-search-flights {
        background-color: #0084c7;
        color: #ffffff;
        border-radius: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        padding: 0.85rem 1.5rem;
        height: 52px;
        border: none;
        box-shadow: 0 6px 20px rgba(0, 132, 199, 0.35);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-search-flights:hover {
        background-color: #0073b0;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0, 132, 199, 0.45);
    }

    .destination-card-figma {
        position: relative;
        height: 420px;
        border-radius: 26px;
        overflow: hidden;
        border: none;
        display: block;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(16, 45, 69, 0.08);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .destination-card-figma:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px rgba(16, 45, 69, 0.16);
    }

    .destination-card-figma img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .destination-card-figma:hover img {
        transform: scale(1.06);
    }

    .destination-gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(7, 26, 44, 0.1) 0%, rgba(7, 26, 44, 0.3) 50%, rgba(7, 26, 44, 0.92) 100%);
    }

    .destination-card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.75rem;
        color: #ffffff;
        z-index: 2;
    }

    .destination-heart-btn {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        display: grid;
        place-items: center;
        color: #ffffff;
        border: none;
        z-index: 2;
    }

    .why-us-section {
        background-color: #102d45;
        color: #ffffff;
        padding: 5.5rem 0;
    }

    .why-us-card {
        background-color: #15344e;
        padding: 2rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        height: 100%;
        transition: transform 0.25s ease;
    }

    .why-us-card:hover {
        transform: translateY(-3px);
    }

    .why-us-icon-box {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: rgba(255, 107, 74, 0.16);
        color: #ff8b73;
        display: grid;
        place-items: center;
        font-size: 1.2rem;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 18px;
        padding: 1rem 1.25rem;
    }

    @media (max-width: 767.98px) {
        .hero-section {
            padding: 3.5rem 0 4.5rem;
        }
        .hero-search-card {
            padding: 1.2rem;
            border-radius: 22px;
        }
        .destination-card-figma {
            height: 360px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section (Figma Make Theme) -->
<section class="hero-section text-center text-md-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9 mx-auto text-center">
                <span class="hero-kicker-pill mb-3">
                    <span class="hero-dot-gold"></span>
                    Curated journeys, made personal
                </span>
                
                <h1 class="hero-title">
                    Go where you feel most alive.
                </h1>
                
                <p class="lead text-light opacity-90 mb-4 px-md-5" style="font-size: 1.15rem; font-weight: 400;">
                    Thoughtfully planned journeys, extraordinary hotel stays, and seamless flights across Pakistan and the world — all in one beautiful place.
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

        <!-- Universal Multi-Tab Search Card (Matching User Screenshot UI) -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="hero-search-card">
                    <!-- Tab Buttons matching user's exact sequence & pill styling -->
                    <ul class="nav nav-pills" id="searchTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link" id="packages-tab" data-bs-toggle="pill" data-bs-target="#tab-packages" type="button">
                                <i class="fa-solid fa-umbrella-beach"></i> Vacation Packages
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link active" id="flights-tab" data-bs-toggle="pill" data-bs-target="#tab-flights" type="button">
                                <i class="fa-solid fa-plane"></i> Flights
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="hotels-tab" data-bs-toggle="pill" data-bs-target="#tab-hotels" type="button">
                                <i class="fa-solid fa-hotel"></i> Hotels
                            </button>
                        </li>
                    </ul>

                    <div class="search-card-divider"></div>

                    <div class="tab-content" id="searchTabsContent">
                        <!-- Tab 1: Flights (Exact match to User Screenshot with Pakistan Airports Dropdown) -->
                        <div class="tab-pane fade show active" id="tab-flights">
                            <form action="{{ route('search') }}" method="GET" class="d-flex flex-column gap-3">
                                <input type="hidden" name="tab" value="flights">
                                
                                <div>
                                    <x-airport-select 
                                        name="origin" 
                                        id="home_flight_origin" 
                                        label="From (City / Code)" 
                                        placeholder="e.g. Karachi, Islamabad" 
                                        icon="fa-plane" 
                                        iconColor="#0084c7"
                                        badgeBg="#e0f2fe"
                                        badgeColor="#0084c7"
                                    />
                                </div>

                                <div>
                                    <x-airport-select 
                                        name="destination" 
                                        id="home_flight_dest" 
                                        label="To (City / Code)" 
                                        placeholder="e.g. Skardu, Dubai" 
                                        icon="fa-plane-arrival" 
                                        iconColor="#0084c7"
                                        badgeBg="#e0f2fe"
                                        badgeColor="#0084c7"
                                    />
                                </div>

                                <div>
                                    <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                        <i class="fa-solid fa-calendar-days" style="color: #0084c7; font-size: 1rem;"></i>
                                        <span>Departure Date</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        name="flight_date" 
                                        class="form-control search-input-clean" 
                                        min="{{ date('Y-m-d') }}"
                                    >
                                </div>

                                <div class="pt-1">
                                    <button type="submit" class="btn btn-search-flights w-100">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <span>Search Flights</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2: Vacation Packages (Clean Stacked Card Style) -->
                        <div class="tab-pane fade" id="tab-packages">
                            <form action="{{ route('search') }}" method="GET" class="d-flex flex-column gap-3">
                                <input type="hidden" name="tab" value="packages">
                                
                                <div>
                                    <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                        <i class="fa-solid fa-location-dot" style="color: #0084c7; font-size: 1rem;"></i>
                                        <span>Destination or Tour Name</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="package_destination" 
                                        class="form-control search-input-clean" 
                                        placeholder="e.g. Hunza, Skardu, Murree, Dubai"
                                    >
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                            <i class="fa-solid fa-clock" style="color: #0084c7; font-size: 1rem;"></i>
                                            <span>Max Duration</span>
                                        </label>
                                        <select name="duration" class="form-select search-input-clean">
                                            <option value="">Any Duration</option>
                                            <option value="3">Up to 3 Days</option>
                                            <option value="5">Up to 5 Days</option>
                                            <option value="7">Up to 7 Days</option>
                                            <option value="10">Up to 10 Days</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                            <i class="fa-solid fa-wallet" style="color: #0084c7; font-size: 1rem;"></i>
                                            <span>Max Budget</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            name="max_package_price" 
                                            class="form-control search-input-clean" 
                                            placeholder="e.g. 50000"
                                        >
                                    </div>
                                </div>

                                <div class="pt-1">
                                    <button type="submit" class="btn btn-search-flights w-100">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <span>Search Packages</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 3: Hotels (Clean Stacked Card Style) -->
                        <div class="tab-pane fade" id="tab-hotels">
                            <form action="{{ route('search') }}" method="GET" class="d-flex flex-column gap-3">
                                <input type="hidden" name="tab" value="hotels">
                                
                                <div>
                                    <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                        <i class="fa-solid fa-city" style="color: #0084c7; font-size: 1rem;"></i>
                                        <span>City or Hotel Name</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="hotel_city" 
                                        class="form-control search-input-clean" 
                                        placeholder="e.g. Islamabad, Lahore, Hunza, Skardu"
                                    >
                                </div>

                                <div>
                                    <label class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
                                        <i class="fa-solid fa-star" style="color: #0084c7; font-size: 1rem;"></i>
                                        <span>Minimum Star Rating</span>
                                    </label>
                                    <select name="star_rating" class="form-select search-input-clean">
                                        <option value="">Any Star Rating</option>
                                        <option value="5">5 Stars Luxury</option>
                                        <option value="4">4 Stars & Above</option>
                                        <option value="3">3 Stars & Above</option>
                                    </select>
                                </div>

                                <div class="pt-1">
                                    <button type="submit" class="btn btn-search-flights w-100">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <span>Search Hotels</span>
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

<!-- Handpicked Destinations Section (Figma Make Style) -->
<section class="py-5" style="background-color: #fafaf7;">
    <div class="container py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <p class="section-kicker mb-1">Handpicked for you</p>
                <h2 class="section-title mb-0">Places worth getting lost in</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="btn btn-sm fw-bold text-decoration-none d-inline-flex align-items-center gap-2" style="color: #e85335;">
                Explore all destinations <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Hunza']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1779831859141-452040bc1463?auto=format&fit=crop&w=900&q=85" alt="Hunza Valley">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white-50 mb-1">Gilgit-Baltistan &bull; 8 Curated Stays</p>
                        <h3 class="fw-bold mb-1 text-white">Hunza Valley</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 0.95rem;">From PKR 35,000</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Skardu']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1769939830039-3291f2721e8c?auto=format&fit=crop&w=900&q=85" alt="Skardu Shangrila">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white-50 mb-1">Karakoram &bull; 12 Curated Stays</p>
                        <h3 class="fw-bold mb-1 text-white">Skardu & Deosai</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 0.95rem;">From PKR 42,000</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Dubai']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1760535560326-656c93894369?auto=format&fit=crop&w=900&q=85" alt="Dubai & Arabian Coast">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white-50 mb-1">International &bull; 9 Curated Stays</p>
                        <h3 class="fw-bold mb-1 text-white">Dubai & Emirates</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 0.95rem;">From PKR 95,000</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Scheduled Flights Showcase -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-soft-primary text-uppercase px-3 py-1 mb-2">Non-Stop & Direct</span>
                <h2 class="fw-bold text-dark mb-0">Scheduled Domestic Flights</h2>
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
                            <span class="badge font-monospace fw-bold px-2 py-1" style="background-color: #ff6b4a; color: white;">{{ $flight->flight_number }}</span>
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
                                <i class="fa-solid fa-plane" style="color: #ff6b4a;"></i>
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
<section class="py-5" style="background-color: #fafaf7;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
            <div>
                <span class="badge badge-soft-primary text-uppercase px-3 py-1 mb-2">Curated Escapes</span>
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
                        <div style="height: 220px; overflow: hidden; position: relative;">
                            <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $pkg->name }}">
                            @if($pkg->is_featured)
                                <span class="badge position-absolute top-0 start-0 m-3 px-3 py-1 fw-bold" style="background-color: #ffb64d; color: #102a43;">FEATURED</span>
                            @endif
                            @if($pkg->discount_percent > 0)
                                <span class="badge position-absolute top-0 end-0 m-3 px-3 py-1 fw-bold" style="background-color: #ff6b4a; color: white;">{{ $pkg->discount_percent }}% OFF</span>
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-muted border">
                                    <i class="fa-solid fa-clock me-1 text-danger" style="color: #ff6b4a !important;"></i> {{ $pkg->duration_days }}D / {{ $pkg->duration_nights }}N
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
                                    <div class="fw-extrabold text-danger fs-5" style="color: #e54e2e !important;">
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

<!-- Why Us Section (Figma Make Deep Navy Section) -->
<section class="why-us-section" id="why-us">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <p class="section-kicker mb-2" style="color: #ff8b73 !important;">Travel Differently</p>
                <h2 class="font-display display-5 fw-bold text-white mb-4" style="line-height: 1.15;">
                    The world is wide.<br>
                    We make it feel simple.
                </h2>
                <p class="lead text-white-50 mb-0" style="font-size: 1.05rem;">
                    From your first idea to your journey home, every reservation, hotel stay, and flight is handled with care by travel specialists.
                </p>
            </div>

            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="why-us-card">
                            <div class="why-us-icon-box mb-3">
                                <i class="fa-solid fa-compass"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Tailored Itineraries</h5>
                            <p class="small text-white-50 mb-0">Trips shaped around your exact pace, budget, and curiosity across Pakistan and abroad.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="why-us-card">
                            <div class="why-us-icon-box mb-3">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Clear, Honest Pricing</h5>
                            <p class="small text-white-50 mb-0">No surprise hidden fees. Transparent fares with instant receipts and refund policies.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="why-us-card">
                            <div class="why-us-icon-box mb-3">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Vetted Experiences</h5>
                            <p class="small text-white-50 mb-0">Every partner hotel, airline route, and tour guide is verified for quality and safety.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="why-us-card">
                            <div class="why-us-icon-box mb-3">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2">Human Support, Always</h5>
                            <p class="small text-white-50 mb-0">Dedicated travel assistants available whenever you need help before, during, or after travel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ready to Make the World Yours CTA (Figma Make Style) -->
<section class="py-5 text-center" style="background-color: #fafaf7;">
    <div class="container py-4">
        <p class="section-kicker mb-2">Your next chapter</p>
        <h2 class="section-title mx-auto mb-3" style="max-width: 650px;">
            Ready to make the world yours?
        </h2>
        <p class="text-muted mx-auto mb-4" style="max-width: 520px; font-size: 1.05rem;">
            Tell us where you want to go. We'll turn it into an unforgettable journey with instant online reservations.
        </p>
        <a href="{{ route('search') }}" class="btn btn-primary-custom px-5 py-3 shadow-lg">
            Start planning <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
    </div>
</section>

<!-- CS619 FYP Supervisor & Project Info Section -->
<section class="py-4 border-top" style="background-color: #ffffff;">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <span class="badge px-3 py-1 mb-2 font-monospace" style="background-color: #fff0ec; color: #e54e2e; font-size: 0.75rem;">CS619 Final Year Project</span>
                <h5 class="fw-bold mb-1 text-dark">Travel Booking Application using MVC-based Framework</h5>
                <p class="small text-muted mb-0 leading-relaxed">
                    Designed and built adhering to the Model-View-Controller (MVC) architectural pattern in Laravel 12. Implements full CRUD operations, database migrations, airport dropdowns, transactional checkout simulation, and administrator monitoring.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="p-3 rounded-4 border text-start bg-light">
                    <div class="fw-bold text-dark small mb-1"><i class="fa-solid fa-user-tie me-1" style="color: #ff6b4a;"></i> Project Supervisor</div>
                    <div class="fw-bold text-dark">Sheikh Israr Ahmad</div>
                    <div class="small text-muted">Virtual University of Pakistan</div>
                    <div class="small text-muted"><i class="fa-solid fa-envelope me-1"></i> israr.ahmad@vu.edu.pk</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
