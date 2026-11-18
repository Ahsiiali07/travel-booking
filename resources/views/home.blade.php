@extends('layouts.app')

@section('title', 'Go Where You Feel Most Alive')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(90deg, rgba(7, 25, 43, 0.88) 0%, rgba(7, 25, 43, 0.52) 47%, rgba(7, 25, 43, 0.08) 100%),
                    url('https://images.unsplash.com/photo-1774681972371-d87f13a3996c?auto=format&fit=crop&w=2000&q=88') center/cover no-repeat;
        padding: 5.5rem 0 6.5rem;
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
        padding: 0.45rem 1.15rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
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
        font-size: clamp(2.6rem, 5.5vw, 4.8rem);
        line-height: 1.04;
        font-weight: 700;
        letter-spacing: -0.04em;
        color: #ffffff;
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        max-width: 820px;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        max-width: 650px;
        font-weight: 400;
    }

    /* Horizontal Search Card (Figma Make Exact Style) */
    .hero-search-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 60px -15px rgba(7, 25, 43, 0.35), 0 10px 20px -5px rgba(0, 0, 0, 0.1);
        padding: 0.95rem;
        margin-top: 2.75rem;
        border: 1px solid rgba(255, 255, 255, 0.95);
        max-width: 1040px;
    }

    .hero-search-card .nav-pills {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.65rem;
        padding-left: 0.35rem;
    }

    .hero-search-card .nav-pills .nav-link {
        font-weight: 700;
        font-size: 0.92rem;
        color: #64748b;
        border-radius: 12px;
        padding: 0.65rem 1.15rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        transition: all 0.2s ease;
        background: transparent;
    }

    .hero-search-card .nav-pills .nav-link:hover {
        background: #f8fafc;
        color: #102a43;
    }

    .hero-search-card .nav-pills .nav-link.active {
        background-color: #fff0ec !important;
        color: #e54e2e !important;
        box-shadow: none;
    }

    /* Search Field Capsule in #fafaf8 with rounded-2xl */
    .search-capsule {
        background: #fafaf8;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 0.65rem 1rem;
        min-height: 64px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        position: relative;
    }

    .search-capsule:focus-within {
        border-color: #ff6b4a;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(255, 107, 74, 0.12);
    }

    .search-capsule-icon {
        color: #e85335;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .search-capsule-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 2px;
        line-height: 1;
    }

    .search-capsule-input {
        border: none;
        background: transparent;
        padding: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #102a43;
        width: 100%;
        outline: none;
        box-shadow: none !important;
    }

    .search-capsule-input::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    .btn-search-figma {
        background: #ff6b4a;
        color: #ffffff;
        border: none;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1.05rem;
        padding: 0 2rem;
        min-height: 64px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        box-shadow: 0 4px 14px rgba(255, 107, 74, 0.35);
        transition: all 0.25s ease;
    }

    .btn-search-figma:hover {
        background: #ee5b3c;
        transform: translateY(-1px);
        box-shadow: 0 8px 22px rgba(255, 107, 74, 0.45);
        color: #ffffff;
    }

    /* Destination Card (Figma Make Exact Match: 440px height, rounded-[26px], heart button) */
    .destination-card-figma {
        position: relative;
        height: 440px;
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
        background: linear-gradient(180deg, rgba(7, 26, 44, 0.08) 0%, rgba(7, 26, 44, 0.3) 50%, rgba(7, 26, 44, 0.9) 100%);
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
        top: 20px;
        right: 20px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        display: grid;
        place-items: center;
        color: #ffffff;
        border: none;
        z-index: 2;
        transition: background-color 0.2s, transform 0.2s;
    }

    .destination-heart-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.1);
        color: #ff6b4a;
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

        <!-- Universal Horizontal Search Card (Figma Make Exact Match) -->
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="hero-search-card">
                    <!-- Tab Buttons matching user's exact sequence & pill styling -->
                    <ul class="nav nav-pills" id="searchTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="flights-tab" data-bs-toggle="pill" data-bs-target="#tab-flights" type="button">
                                <i class="fa-solid fa-paper-plane"></i> Flights
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="hotels-tab" data-bs-toggle="pill" data-bs-target="#tab-hotels" type="button">
                                <i class="fa-solid fa-hotel"></i> Hotels
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="packages-tab" data-bs-toggle="pill" data-bs-target="#tab-packages" type="button">
                                <i class="fa-solid fa-box-archive"></i> Packages
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-1" id="searchTabsContent">
                        <!-- Tab 1: Flights (Horizontal 4-Column Grid with Pakistan Airports Dropdown) -->
                        <div class="tab-pane fade show active" id="tab-flights">
                            <form action="{{ route('search') }}" method="GET">
                                <input type="hidden" name="tab" value="flights">
                                
                                <div class="row g-2 align-items-center">
                                    <!-- Segment 1: From & To with Pakistan Airports -->
                                    <div class="col-12 col-lg-5">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-location-dot search-capsule-icon"></i>
                                            <div class="w-100 position-relative">
                                                <div class="search-capsule-label">From & To (Pakistan & Hubs)</div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="flex-grow-1 position-relative airport-search-wrapper" id="wrapper-h-origin">
                                                        <input 
                                                            type="text" 
                                                            name="origin" 
                                                            id="home_flight_origin" 
                                                            class="search-capsule-input airport-search-input" 
                                                            placeholder="Karachi (KHI)" 
                                                            autocomplete="off"
                                                        >
                                                        <!-- Airports Dropdown Popup -->
                                                        <div class="airport-dropdown-menu shadow-lg border rounded-4 p-2 bg-white" style="display: none; position: absolute; top: calc(100% + 14px); left: -30px; width: 320px; z-index: 1060; max-height: 280px; overflow-y: auto;">
                                                            <div class="px-2 py-1 pb-2 border-bottom mb-1 small text-muted d-flex justify-content-between align-items-center">
                                                                <span class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #64748b;">Origin Airports</span>
                                                                <span class="badge" style="background: #fff0ec; color: #e54e2e;">PK</span>
                                                            </div>
                                                            <div class="airport-options-list">
                                                                @foreach(config('airports.pakistan', []) as $ap)
                                                                    <div class="airport-option p-2 rounded-3 d-flex justify-content-between align-items-center cursor-pointer" 
                                                                         data-value="{{ $ap['city'] }} ({{ $ap['code'] }})"
                                                                         data-city="{{ strtolower($ap['city']) }}"
                                                                         data-code="{{ strtolower($ap['code']) }}"
                                                                         data-name="{{ strtolower($ap['name']) }}"
                                                                         style="cursor: pointer; transition: background-color 0.15s ease;">
                                                                         <div>
                                                                             <div class="fw-bold text-dark small">{{ $ap['city'] }}</div>
                                                                             <div class="text-muted" style="font-size: 0.72rem;">{{ $ap['name'] }}</div>
                                                                         </div>
                                                                         <span class="badge font-monospace fw-bold ms-2" style="background: #fff0ec; color: #e54e2e; font-size: 0.75rem;">{{ $ap['code'] }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <span class="text-muted small fw-bold px-1" style="color: #ff6b4a !important;">&rarr;</span>

                                                    <div class="flex-grow-1 position-relative airport-search-wrapper" id="wrapper-h-dest">
                                                        <input 
                                                            type="text" 
                                                            name="destination" 
                                                            id="home_flight_dest" 
                                                            class="search-capsule-input airport-search-input" 
                                                            placeholder="Islamabad (ISB)" 
                                                            autocomplete="off"
                                                        >
                                                        <!-- Destination Dropdown Popup -->
                                                        <div class="airport-dropdown-menu shadow-lg border rounded-4 p-2 bg-white" style="display: none; position: absolute; top: calc(100% + 14px); right: 0; width: 320px; z-index: 1060; max-height: 280px; overflow-y: auto;">
                                                            <div class="px-2 py-1 pb-2 border-bottom mb-1 small text-muted d-flex justify-content-between align-items-center">
                                                                <span class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #64748b;">Destination Airports</span>
                                                                <span class="badge" style="background: #fff0ec; color: #e54e2e;">HUB</span>
                                                            </div>
                                                            <div class="airport-options-list">
                                                                @foreach(config('airports.pakistan', []) as $ap)
                                                                    <div class="airport-option p-2 rounded-3 d-flex justify-content-between align-items-center cursor-pointer" 
                                                                         data-value="{{ $ap['city'] }} ({{ $ap['code'] }})"
                                                                         data-city="{{ strtolower($ap['city']) }}"
                                                                         data-code="{{ strtolower($ap['code']) }}"
                                                                         data-name="{{ strtolower($ap['name']) }}"
                                                                         style="cursor: pointer; transition: background-color 0.15s ease;">
                                                                         <div>
                                                                             <div class="fw-bold text-dark small">{{ $ap['city'] }}</div>
                                                                             <div class="text-muted" style="font-size: 0.72rem;">{{ $ap['name'] }}</div>
                                                                         </div>
                                                                         <span class="badge font-monospace fw-bold ms-2" style="background: #fff0ec; color: #e54e2e; font-size: 0.75rem;">{{ $ap['code'] }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Segment 2: Travel Dates -->
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-calendar-days search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Travel Dates</div>
                                                <input 
                                                    type="date" 
                                                    name="flight_date" 
                                                    class="search-capsule-input" 
                                                    min="{{ date('Y-m-d') }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Segment 3: Travelers / Class -->
                                    <div class="col-12 col-sm-6 col-lg-2">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-users search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Travelers</div>
                                                <select name="seat_class" class="search-capsule-input bg-transparent border-0 cursor-pointer">
                                                    <option value="">2 guests, 1 room</option>
                                                    <option value="Economy">Economy</option>
                                                    <option value="Business">Business</option>
                                                    <option value="First Class">First Class</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Segment 4: Search Button -->
                                    <div class="col-12 col-lg-2">
                                        <button type="submit" class="btn btn-search-figma">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span>Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2: Hotels (Horizontal Layout) -->
                        <div class="tab-pane fade" id="tab-hotels">
                            <form action="{{ route('search') }}" method="GET">
                                <input type="hidden" name="tab" value="hotels">
                                
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-lg-5">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-hotel search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Destination / Hotel</div>
                                                <input 
                                                    type="text" 
                                                    name="hotel_city" 
                                                    class="search-capsule-input" 
                                                    placeholder="Lahore, Islamabad, Hunza, Skardu..."
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-calendar-days search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Check-In Date</div>
                                                <input 
                                                    type="date" 
                                                    name="check_in" 
                                                    class="search-capsule-input" 
                                                    min="{{ date('Y-m-d') }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-2">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-star search-capsule-icon text-warning"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Min Rating</div>
                                                <select name="star_rating" class="search-capsule-input bg-transparent border-0 cursor-pointer">
                                                    <option value="">Any Rating</option>
                                                    <option value="5">5 Stars Luxury</option>
                                                    <option value="4">4 Stars & Above</option>
                                                    <option value="3">3 Stars & Above</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-2">
                                        <button type="submit" class="btn btn-search-figma">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span>Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 3: Packages (Horizontal Layout) -->
                        <div class="tab-pane fade" id="tab-packages">
                            <form action="{{ route('search') }}" method="GET">
                                <input type="hidden" name="tab" value="packages">
                                
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-lg-5">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-umbrella-beach search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Tour Destination / Package</div>
                                                <input 
                                                    type="text" 
                                                    name="package_destination" 
                                                    class="search-capsule-input" 
                                                    placeholder="Hunza, Skardu, Murree, Swat, Dubai..."
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-clock search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Max Duration</div>
                                                <select name="duration" class="search-capsule-input bg-transparent border-0 cursor-pointer">
                                                    <option value="">Any Duration</option>
                                                    <option value="3">Up to 3 Days</option>
                                                    <option value="5">Up to 5 Days</option>
                                                    <option value="7">Up to 7 Days</option>
                                                    <option value="10">Up to 10 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-2">
                                        <div class="search-capsule">
                                            <i class="fa-solid fa-wallet search-capsule-icon"></i>
                                            <div class="w-100">
                                                <div class="search-capsule-label">Max Budget (PKR)</div>
                                                <input 
                                                    type="number" 
                                                    name="max_package_price" 
                                                    class="search-capsule-input" 
                                                    placeholder="e.g. 50000"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-2">
                                        <button type="submit" class="btn btn-search-figma">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <span>Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Handpicked Destinations Section (Figma Make Exact Match: Amalfi Coast, Marina Bay, Madeira) -->
<section id="destinations" class="py-5" style="background-color: #fafaf7;">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <p class="section-kicker mb-1">Handpicked for you</p>
                <h2 class="section-title mb-0">Places worth getting lost in</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="btn btn-sm fw-bold text-decoration-none d-inline-flex align-items-center gap-2" style="color: #e85335; font-size: 0.95rem;">
                Explore all destinations <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <!-- Card 1: Amalfi Coast (From User Screenshot) -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Amalfi Coast']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1779831859141-452040bc1463?auto=format&fit=crop&w=900&q=85" alt="Amalfi Coast">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white opacity-75 mb-1" style="font-size: 0.82rem;">Italy &bull; 8 curated stays</p>
                        <h3 class="fw-bold mb-1 text-white" style="font-family: 'Manrope', sans-serif; font-size: 1.85rem;">Amalfi Coast</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 1rem;">From $1,240 <span class="small opacity-75">(PKR 345,000)</span></p>
                    </div>
                </a>
            </div>

            <!-- Card 2: Marina Bay (From User Screenshot) -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Marina Bay']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1769939830039-3291f2721e8c?auto=format&fit=crop&w=900&q=85" alt="Marina Bay">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white opacity-75 mb-1" style="font-size: 0.82rem;">Singapore &bull; 12 curated stays</p>
                        <h3 class="fw-bold mb-1 text-white" style="font-family: 'Manrope', sans-serif; font-size: 1.85rem;">Marina Bay</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 1rem;">From $980 <span class="small opacity-75">(PKR 270,000)</span></p>
                    </div>
                </a>
            </div>

            <!-- Card 3: Madeira (From User Screenshot) -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('search', ['tab' => 'packages', 'package_destination' => 'Madeira']) }}" class="destination-card-figma">
                    <img src="https://images.unsplash.com/photo-1760535560326-656c93894369?auto=format&fit=crop&w=900&q=85" alt="Madeira">
                    <div class="destination-gradient-overlay"></div>
                    <button class="destination-heart-btn" type="button" title="Save to favorites">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <div class="destination-card-content">
                        <p class="small text-white opacity-75 mb-1" style="font-size: 0.82rem;">Portugal &bull; 9 curated stays</p>
                        <h3 class="fw-bold mb-1 text-white" style="font-family: 'Manrope', sans-serif; font-size: 1.85rem;">Madeira</h3>
                        <p class="fw-semibold mb-0 text-white" style="font-size: 1rem;">From $860 <span class="small opacity-75">(PKR 240,000)</span></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupAirportPicker(inputId, wrapperId) {
        const input = document.getElementById(inputId);
        const wrapper = document.getElementById(wrapperId);
        if (!input || !wrapper) return;
        const menu = wrapper.querySelector('.airport-dropdown-menu');
        if (!menu) return;
        const options = wrapper.querySelectorAll('.airport-option');

        function openMenu() {
            document.querySelectorAll('.airport-dropdown-menu').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });
            menu.style.display = 'block';
            filter(input.value);
        }

        function closeMenu() {
            menu.style.display = 'none';
        }

        function filter(val) {
            const term = (val || '').toLowerCase().trim();
            options.forEach(opt => {
                const city = opt.getAttribute('data-city') || '';
                const code = opt.getAttribute('data-code') || '';
                const name = opt.getAttribute('data-name') || '';
                if (!term || city.includes(term) || code.includes(term) || name.includes(term)) {
                    opt.style.display = 'flex';
                } else {
                    opt.style.display = 'none';
                }
            });
        }

        input.addEventListener('focus', openMenu);
        input.addEventListener('click', openMenu);
        input.addEventListener('input', function() {
            openMenu();
            filter(this.value);
        });

        options.forEach(opt => {
            opt.addEventListener('mouseenter', function() { this.style.backgroundColor = '#fff0ec'; });
            opt.addEventListener('mouseleave', function() { this.style.backgroundColor = ''; });
            opt.addEventListener('click', function(e) {
                e.stopPropagation();
                input.value = this.getAttribute('data-value');
                closeMenu();
            });
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                closeMenu();
            }
        });
    }

    setupAirportPicker('home_flight_origin', 'wrapper-h-origin');
    setupAirportPicker('home_flight_dest', 'wrapper-h-dest');
});
</script>
@endpush
@endsection
