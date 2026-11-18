@extends('layouts.admin')

@section('title', 'Add New Flight')
@section('page_title', 'Create Flight Schedule')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Schedule New Flight Route</h5>
                <a href="{{ route('admin.flights.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Flight List
                </a>
            </div>

            <form action="{{ route('admin.flights.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Airline Operator <span class="text-danger">*</span></label>
                        <input type="text" name="airline" class="form-control" value="{{ old('airline', 'Pakistan International Airlines') }}" required placeholder="e.g. PIA, Airblue, Emirates">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Flight Number <span class="text-danger">*</span></label>
                        <input type="text" name="flight_number" class="form-control" value="{{ old('flight_number') }}" required placeholder="e.g. PK-785">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Origin City <span class="text-danger">*</span></label>
                        <input type="text" name="origin_city" class="form-control" value="{{ old('origin_city') }}" required placeholder="e.g. Islamabad" list="pak_cities_list">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Destination City <span class="text-danger">*</span></label>
                        <input type="text" name="destination_city" class="form-control" value="{{ old('destination_city') }}" required placeholder="e.g. Skardu" list="pak_cities_list">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Origin Airport Name & Code <span class="text-danger">*</span></label>
                        <input type="text" name="origin_airport" class="form-control" value="{{ old('origin_airport') }}" required placeholder="e.g. Islamabad International Airport (ISB)" list="pak_airports_list">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Destination Airport Name & Code <span class="text-danger">*</span></label>
                        <input type="text" name="destination_airport" class="form-control" value="{{ old('destination_airport') }}" required placeholder="e.g. Skardu International Airport (KDU)" list="pak_airports_list">
                    </div>

                    <datalist id="pak_cities_list">
                        @foreach(config('airports.pakistan', []) as $ap)
                            <option value="{{ $ap['city'] }}">{{ $ap['code'] }}</option>
                        @endforeach
                    </datalist>

                    <datalist id="pak_airports_list">
                        @foreach(config('airports.pakistan', []) as $ap)
                            <option value="{{ $ap['name'] }} ({{ $ap['code'] }})">{{ $ap['city'] }}</option>
                        @endforeach
                    </datalist>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Departure Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="departure_time" class="form-control" value="{{ old('departure_time') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Arrival Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="arrival_time" class="form-control" value="{{ old('arrival_time') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Flight Duration <span class="text-danger">*</span></label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration', '1h 45m') }}" required placeholder="e.g. 1h 45m">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Default Seat Class <span class="text-danger">*</span></label>
                        <select name="seat_class" class="form-select" required>
                            <option value="Economy" {{ old('seat_class') == 'Economy' ? 'selected' : '' }}>Economy</option>
                            <option value="Business" {{ old('seat_class') == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="First Class" {{ old('seat_class') == 'First Class' ? 'selected' : '' }}>First Class</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Fare per Seat (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_per_seat" class="form-control" value="{{ old('price_per_seat', '18000') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Total Capacity Seats <span class="text-danger">*</span></label>
                        <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats', '180') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Available Seats <span class="text-danger">*</span></label>
                        <input type="number" name="available_seats" class="form-control" value="{{ old('available_seats', '180') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Flight Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="delayed">Delayed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Aircraft Model</label>
                        <input type="text" name="aircraft_type" class="form-control" value="{{ old('aircraft_type', 'Airbus A320') }}" placeholder="Airbus A320, Boeing 777">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Baggage Allowance Policy</label>
                        <input type="text" name="baggage_allowance" class="form-control" value="{{ old('baggage_allowance', '20 KG Checked + 7 KG Hand Carry') }}">
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-plus me-1"></i> Register Flight Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
