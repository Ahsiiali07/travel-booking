@extends('layouts.app')

@section('title', 'Book Package: ' . $package->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <!-- Package Summary Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <div>
                        <span class="badge bg-success-subtle text-success text-uppercase">
                            <i class="fa-solid fa-clock me-1"></i> {{ $package->duration_days }} Days / {{ $package->duration_nights }} Nights
                        </span>
                        <h4 class="fw-bold mb-0 mt-1 text-dark">{{ $package->name }}</h4>
                        <div class="small text-muted"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $package->destination }}, {{ $package->country }}</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small">Package Rate</span>
                        <div class="fw-bold fs-5 text-primary">PKR {{ number_format($package->final_price) }} / person</div>
                    </div>
                </div>

                <form action="{{ route('user.package-bookings.store', $package->id) }}" method="POST" id="packageBookingForm">
                    @csrf
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-calendar-check text-primary me-2"></i> Tour Departure & Travelers</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Departure / Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="travel_date" class="form-control @error('travel_date') is-invalid @enderror" value="{{ old('travel_date', date('Y-m-d', strtotime('+3 days'))) }}" min="{{ date('Y-m-d') }}" required>
                            @error('travel_date')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Number of Travelers <span class="text-danger">*</span></label>
                            <input type="number" name="travelers_count" id="travelersCount" class="form-control" value="1" min="1" max="{{ $package->available_slots }}" required onchange="updateTravelerFields(); calculatePackageFare();">
                            <div class="small text-muted mt-1">{{ $package->available_slots }} slots available for this tour.</div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Special Notes / Dietary Requirements</label>
                            <input type="text" name="special_requests" class="form-control" placeholder="e.g. Vegetarian food only, elderly traveler assistance">
                        </div>
                    </div>

                    <!-- Lead Traveler Contact -->
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-address-book text-primary me-2"></i> Lead Traveler Contact Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', auth()->user()->email) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', auth()->user()->phone) }}" required placeholder="+92-300-1234567">
                        </div>
                    </div>

                    <!-- Traveler Details -->
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-users text-primary me-2"></i> Traveler Details</h5>
                    <div id="travelerContainer" class="d-flex flex-column gap-3 mb-4">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fw-bold small text-muted mb-2">Traveler 1 (Lead Passenger)</div>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <input type="text" name="passenger_names[]" class="form-control" placeholder="Full Name as on CNIC/Passport" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="passenger_cnics[]" class="form-control" placeholder="CNIC / Passport Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Estimate Box -->
                    <div class="bg-primary-subtle p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted" id="travelerCountLabel">Total for 1 Traveler (+5% tax)</div>
                            <div class="fw-bold fs-4 text-primary" id="packageTotalFare">PKR {{ number_format($package->final_price * 1.05) }}</div>
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
const packagePrice = {{ $package->final_price }};

function calculatePackageFare() {
    const count = parseInt(document.getElementById('travelersCount').value) || 1;
    const subtotal = packagePrice * count;
    const tax = subtotal * 0.05;
    const total = subtotal + tax;

    document.getElementById('travelerCountLabel').innerText = `Total for ${count} Traveler(s) (+5% tax)`;
    document.getElementById('packageTotalFare').innerText = 'PKR ' + Math.round(total).toLocaleString();
}

function updateTravelerFields() {
    const count = parseInt(document.getElementById('travelersCount').value) || 1;
    const container = document.getElementById('travelerContainer');
    container.innerHTML = '';

    for (let i = 1; i <= count; i++) {
        const div = document.createElement('div');
        div.className = 'p-3 border rounded-3 bg-light';
        div.innerHTML = `
            <div class="fw-bold small text-muted mb-2">Traveler ${i}</div>
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
