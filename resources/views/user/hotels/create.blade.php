@extends('layouts.app')

@section('title', 'Schedule Hotel Stay: ' . $hotel->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <!-- Hotel Summary Banner -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <div>
                        <span class="badge bg-warning-subtle text-dark">
                            @for($i = 0; $i < $hotel->star_rating; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                            {{ $hotel->star_rating }}-Star
                        </span>
                        <h4 class="fw-bold mb-0 mt-1 text-dark">{{ $hotel->name }}</h4>
                        <div class="small text-muted"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->address }}, {{ $hotel->city }}</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small">Nightly Rate</span>
                        <div class="fw-bold fs-5 text-primary">PKR {{ number_format($hotel->price_per_night) }}</div>
                    </div>
                </div>

                <form action="{{ route('user.hotel-schedules.store', $hotel->id) }}" method="POST" id="hotelBookingForm">
                    @csrf
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-calendar-days text-primary me-2"></i> Stay Dates & Room Selection</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Check-in Date <span class="text-danger">*</span></label>
                            <input type="date" name="check_in_date" id="checkInDate" class="form-control @error('check_in_date') is-invalid @enderror" value="{{ old('check_in_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required onchange="calculateHotelFare()">
                            @error('check_in_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Check-out Date <span class="text-danger">*</span></label>
                            <input type="date" name="check_out_date" id="checkOutDate" class="form-control @error('check_out_date') is-invalid @enderror" value="{{ old('check_out_date', date('Y-m-d', strtotime('+2 days'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required onchange="calculateHotelFare()">
                            @error('check_out_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Room Type <span class="text-danger">*</span></label>
                            <select name="room_type" id="roomTypeSelect" class="form-select @error('room_type') is-invalid @enderror" required onchange="calculateHotelFare()">
                                @if($hotel->room_types)
                                    @foreach($hotel->room_types as $type)
                                        <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>
                                            {{ $type }} {{ str_contains(strtolower($type), 'suite') ? '(+40% Luxury Rate)' : '(Standard Rate)' }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Deluxe Room">Deluxe Room</option>
                                    <option value="Executive Suite">Executive Suite</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Total Guests <span class="text-danger">*</span></label>
                            <input type="number" name="guests_count" class="form-control" value="2" min="1" max="10" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Special Requests (Optional)</label>
                            <input type="text" name="special_requests" class="form-control" placeholder="e.g. Early check-in, high floor, non-smoking room">
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-address-book text-primary me-2"></i> Lead Guest Contact Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Contact Email <span class="text-danger">*</span></label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', auth()->user()->email) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Contact Phone <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', auth()->user()->phone) }}" required placeholder="+92-300-1234567">
                        </div>
                    </div>

                    <!-- Price Estimate Box -->
                    <div class="bg-primary-subtle p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted" id="nightCountLabel">Estimated for 2 Nights (+8% tax)</div>
                            <div class="fw-bold fs-4 text-primary" id="hotelTotalFare">PKR {{ number_format($hotel->price_per_night * 2 * 1.08) }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary-custom py-2 px-4">
                            <i class="fa-solid fa-arrow-right me-1"></i> Proceed to Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const hotelRate = {{ $hotel->price_per_night }};

function calculateHotelFare() {
    const checkIn = new Date(document.getElementById('checkInDate').value);
    const checkOut = new Date(document.getElementById('checkOutDate').value);
    const roomType = document.getElementById('roomTypeSelect').value.toLowerCase();

    let diffDays = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
    if (isNaN(diffDays) || diffDays < 1) diffDays = 1;

    let multiplier = roomType.includes('suite') ? 1.4 : 1.0;
    let subtotal = hotelRate * diffDays * multiplier;
    let tax = subtotal * 0.08;
    let total = subtotal + tax;

    document.getElementById('nightCountLabel').innerText = `Estimated for ${diffDays} Night(s) (+8% tax)`;
    document.getElementById('hotelTotalFare').innerText = 'PKR ' + Math.round(total).toLocaleString();
}
</script>
@endsection
