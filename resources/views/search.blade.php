@extends('layouts.app')

@section('title', 'Search Travel Services')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Search Travel Services</h2>
        <p class="text-muted small">Explore flights, hotel stays, and complete vacation packages with flexible filters</p>
    </div>

    <!-- Search Tabs -->
    <div class="card card-custom border-0 shadow-sm mb-4">
        <div class="card-body p-2 p-md-3">
            <ul class="nav nav-pills flex-nowrap overflow-x-auto justify-content-start gap-2 pb-1" id="searchMainTabs" role="tablist" style="scrollbar-width: none;">
                <li class="nav-item">
                    <a class="nav-link text-nowrap rounded-pill py-2 px-4 fw-bold {{ $tab === 'packages' ? 'active' : '' }}" href="{{ route('search', ['tab' => 'packages']) }}">
                        <i class="fa-solid fa-umbrella-beach me-1"></i> Vacation Packages ({{ $packages->total() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap rounded-pill py-2 px-4 fw-bold {{ $tab === 'flights' ? 'active' : '' }}" href="{{ route('search', ['tab' => 'flights']) }}">
                        <i class="fa-solid fa-plane me-1"></i> Flights ({{ $flights->total() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap rounded-pill py-2 px-4 fw-bold {{ $tab === 'hotels' ? 'active' : '' }}" href="{{ route('search', ['tab' => 'hotels']) }}">
                        <i class="fa-solid fa-hotel me-1"></i> Hotels ({{ $hotels->total() }})
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- TAB 1: FLIGHTS WITH AIRPORTS DROPDOWN -->
    @if($tab === 'flights')
        <div class="card card-custom border-0 p-3 p-md-4 mb-4 bg-white shadow-sm">
            <form action="{{ route('search') }}" method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="tab" value="flights">
                
                <div class="col-md-3">
                    <x-airport-select 
                        name="origin" 
                        id="search_flight_origin" 
                        label="From (City / Code)" 
                        value="{{ request('origin') }}" 
                        placeholder="e.g. Karachi, Islamabad" 
                        icon="fa-plane" 
                        iconColor="#ff6b4a"
                        badgeBg="#fff0ec"
                        badgeColor="#e54e2e"
                    />
                </div>

                <div class="col-md-3">
                    <x-airport-select 
                        name="destination" 
                        id="search_flight_dest" 
                        label="To (City / Code)" 
                        value="{{ request('destination') }}" 
                        placeholder="e.g. Skardu, Dubai" 
                        icon="fa-plane-arrival" 
                        iconColor="#ff6b4a"
                        badgeBg="#fff0ec"
                        badgeColor="#e54e2e"
                    />
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1">Cabin Class</label>
                    <select name="seat_class" class="form-select">
                        <option value="">All Classes</option>
                        <option value="Economy" {{ request('seat_class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                        <option value="Business" {{ request('seat_class') == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="First Class" {{ request('seat_class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1">Max Fare (PKR)</label>
                    <input type="number" name="max_flight_price" class="form-control" value="{{ request('max_flight_price') }}" placeholder="Max Price">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="fa-solid fa-filter me-1"></i> Filter Flights</button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($flights as $flight)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom h-100 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary font-monospace fw-bold px-2 py-1">{{ $flight->flight_number }}</span>
                            <span class="badge bg-light text-dark border">{{ $flight->seat_class }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $flight->airline }}</h5>
                        <div class="small text-muted mb-3">{{ $flight->aircraft_type }}</div>

                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light mb-3">
                            <div class="text-start">
                                <div class="fw-bold">{{ $flight->origin_city }}</div>
                                <div class="text-muted small">{{ $flight->departure_time->format('h:i A') }}</div>
                            </div>
                            <div class="text-center px-2">
                                <i class="fa-solid fa-plane text-primary"></i>
                                <div class="text-muted small" style="font-size: 0.72rem;">{{ $flight->duration }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ $flight->destination_city }}</div>
                                <div class="text-muted small">{{ $flight->arrival_time->format('h:i A') }}</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                            <div>
                                <span class="small text-muted">Per Seat</span>
                                <div class="fw-bold text-dark fs-5">PKR {{ number_format($flight->price_per_seat) }}</div>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('flights.show', $flight->id) }}" class="btn-detail-figma">
                                    <i class="fa-regular fa-eye"></i> Details
                                </a>
                                <a href="{{ route('user.flight-schedules.create', $flight->id) }}" class="btn-book-figma">
                                    <i class="fa-solid fa-plane"></i> Schedule
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-plane-slash fs-1 text-muted mb-2"></i>
                    <p class="text-muted">No scheduled flights found matching your search. Try adjusting the airport filters.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $flights->links('pagination::bootstrap-5') }}</div>

    <!-- TAB 2: VACATION PACKAGES -->
    @elseif($tab === 'packages')
        <div class="card card-custom border-0 p-3 p-md-4 mb-4 bg-white shadow-sm">
            <form action="{{ route('search') }}" method="GET" class="row g-2 align-items-end">
                <input type="hidden" name="tab" value="packages">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted mb-1">Destination / Name</label>
                    <input type="text" name="package_destination" class="form-control" value="{{ request('package_destination') }}" placeholder="e.g. Hunza, Skardu, Murree, Dubai">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted mb-1">Max Duration (Days)</label>
                    <input type="number" name="duration" class="form-control" value="{{ request('duration') }}" placeholder="e.g. 7">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1">Max Budget (PKR)</label>
                    <input type="number" name="max_package_price" class="form-control" value="{{ request('max_package_price') }}" placeholder="e.g. 100000">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($packages as $pkg)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom h-100">
                        <div style="height: 190px; overflow: hidden; position: relative;">
                            <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $pkg->name }}">
                            @if($pkg->is_featured)
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2 fw-bold">Featured</span>
                            @endif
                            @if($pkg->discount_percent > 0)
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2 fw-bold">{{ $pkg->discount_percent }}% OFF</span>
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="small text-muted mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $pkg->destination }}, {{ $pkg->country }}</div>
                            <h5 class="fw-bold mb-2">{{ $pkg->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($pkg->description, 90) }}</p>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                                <div>
                                    <div class="small text-muted">{{ $pkg->duration_days }} Days / {{ $pkg->duration_nights }} Nights</div>
                                    <div class="fw-bold fs-5 text-primary">PKR {{ number_format($pkg->final_price) }}</div>
                                </div>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('packages.show', $pkg->id) }}" class="btn-detail-figma">
                                        <i class="fa-regular fa-eye"></i> Details
                                    </a>
                                    <a href="{{ route('user.package-bookings.create', $pkg->id) }}" class="btn-book-figma">
                                        <i class="fa-solid fa-umbrella-beach"></i> Book Tour
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-umbrella-beach fs-1 text-muted mb-2"></i>
                    <p class="text-muted">No vacation packages matched your criteria. Try adjusting your filters.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $packages->links('pagination::bootstrap-5') }}</div>

    <!-- TAB 3: HOTELS -->
    @elseif($tab === 'hotels')
        <div class="card card-custom border-0 p-3 p-md-4 mb-4 bg-white shadow-sm">
            <form action="{{ route('search') }}" method="GET" class="row g-2 align-items-end">
                <input type="hidden" name="tab" value="hotels">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted mb-1">City or Hotel Name</label>
                    <input type="text" name="hotel_city" class="form-control" value="{{ request('hotel_city') }}" placeholder="e.g. Islamabad, Lahore, Hunza, Skardu">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted mb-1">Star Rating</label>
                    <select name="star_rating" class="form-select">
                        <option value="">Any Rating</option>
                        <option value="5" {{ request('star_rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('star_rating') == '4' ? 'selected' : '' }}>4 Stars & Above</option>
                        <option value="3" {{ request('star_rating') == '3' ? 'selected' : '' }}>3 Stars & Above</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1">Max Night Rate (PKR)</label>
                    <input type="number" name="max_hotel_price" class="form-control" value="{{ request('max_hotel_price') }}" placeholder="e.g. 25000">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($hotels as $hotel)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom h-100">
                        <div style="height: 190px; overflow: hidden; position: relative;">
                            <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $hotel->name }}">
                            <div class="position-absolute bottom-0 start-0 m-2">
                                @for($i = 0; $i < $hotel->star_rating; $i++)
                                    <i class="fa-solid fa-star text-warning small"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="small text-muted mb-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->city }}, {{ $hotel->country }}</span>
                            <h5 class="fw-bold mb-2">{{ $hotel->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($hotel->description, 90) }}</p>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                                <div>
                                    <div class="small text-muted">Per Night</div>
                                    <div class="fw-bold fs-5 text-dark">PKR {{ number_format($hotel->price_per_night) }}</div>
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
                    <i class="fa-solid fa-hotel fs-1 text-muted mb-2"></i>
                    <p class="text-muted">No hotels found matching your filter criteria.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $hotels->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
