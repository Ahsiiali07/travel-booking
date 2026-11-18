@extends('layouts.app')

@section('title', 'Schedule Flight: ' . $flight->flight_number)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom p-4 mb-4 border-0 shadow-sm">
                <!-- Flight Summary Banner -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <div>
                        <span class="badge bg-primary text-uppercase">{{ $flight->airline }}</span>
                        <h4 class="fw-bold mb-0 mt-1 text-dark">{{ $flight->origin_city }} &rarr; {{ $flight->destination_city }}</h4>
                        <div class="small text-muted">Flight: <strong>{{ $flight->flight_number }}</strong> &bull; Aircraft: {{ $flight->aircraft_type }}</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small">Standard Fare</span>
                        <div class="fw-bold fs-5 text-primary">PKR {{ number_format($flight->price_per_seat) }} / seat</div>
                    </div>
                </div>

                <form action="{{ route('user.flight-schedules.store', $flight->id) }}" method="POST" id="flightBookingForm">
                    @csrf
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-calendar-check text-primary me-2"></i> Flight Schedule Details</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Travel Date <span class="text-danger">*</span></label>
                            <input type="date" name="travel_date" class="form-control @error('travel_date') is-invalid @enderror" value="{{ old('travel_date', $flight->departure_time->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('travel_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Seat Class <span class="text-danger">*</span></label>
                            <select name="seat_class" id="seatClassSelect" class="form-select @error('seat_class') is-invalid @enderror" required onchange="calculateFare()">
                                <option value="Economy" {{ old('seat_class') == 'Economy' ? 'selected' : '' }}>Economy (Standard Rate)</option>
                                <option value="Business" {{ old('seat_class') == 'Business' ? 'selected' : '' }}>Business (+50% Fare)</option>
                                <option value="First Class" {{ old('seat_class') == 'First Class' ? 'selected' : '' }}>First Class (+100% Fare)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Number of Passengers <span class="text-danger">*</span></label>
                            <input type="number" name="passengers_count" id="passengersCount" class="form-control" value="1" min="1" max="10" required onchange="updatePassengerFields(); calculateFare();">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Special Requests / Meal Preferences</label>
                            <input type="text" name="special_requests" class="form-control" placeholder="e.g. Vegetarian meal, wheelchair assistance">
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-address-book text-primary me-2"></i> Primary Contact Information</h5>
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
                            <label class="form-label small fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', auth()->user()->phone) }}" required placeholder="+92-300-1234567">
                        </div>
                    </div>

                    <!-- Passenger Details -->
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-users text-primary me-2"></i> Passenger Details</h5>
                    <div id="passengerContainer" class="d-flex flex-column gap-3 mb-4">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fw-bold small text-muted mb-2">Passenger 1 (Lead Traveler)</div>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <input type="text" name="passenger_names[]" class="form-control" placeholder="Full Name as on CNIC/Passport" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="passenger_cnics[]" class="form-control" placeholder="CNIC / Passport Number (e.g. 35202-xxxxxxx-x)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Pricing Summary -->
                    <div class="bg-primary-subtle p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Estimated Total (including 5% airport tax)</div>
                            <div class="fw-bold fs-4 text-primary" id="fareTotal">PKR {{ number_format($flight->price_per_seat * 1.05) }}</div>
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
const basePrice = {{ $flight->price_per_seat }};

function calculateFare() {
    const count = parseInt(document.getElementById('passengersCount').value) || 1;
    const seatClass = document.getElementById('seatClassSelect').value;
    let multiplier = 1.0;
    if (seatClass === 'Business') multiplier = 1.5;
    if (seatClass === 'First Class') multiplier = 2.0;

    const subtotal = basePrice * multiplier * count;
    const tax = subtotal * 0.05;
    const total = subtotal + tax;

    document.getElementById('fareTotal').innerText = 'PKR ' + Math.round(total).toLocaleString();
}

function updatePassengerFields() {
    const count = parseInt(document.getElementById('passengersCount').value) || 1;
    const container = document.getElementById('passengerContainer');
    container.innerHTML = '';

    for (let i = 1; i <= count; i++) {
        const div = document.createElement('div');
        div.className = 'p-3 border rounded-3 bg-light';
        div.innerHTML = `
            <div class="fw-bold small text-muted mb-2">Passenger ${i}</div>
            <div class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="passenger_names[]" class="form-control" placeholder="Full Name as on CNIC/Passport" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="passenger_cnics[]" class="form-control" placeholder="CNIC / Passport Number">
                </div>
            </div>
        `;
        container.appendChild(div);
    }
}
</script>
@endsection
