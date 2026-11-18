@extends('layouts.admin')

@section('title', 'Edit Flight: ' . $flight->flight_number)
@section('page_title', 'Update Flight Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Edit Flight: {{ $flight->flight_number }}</h5>
                <a href="{{ route('admin.flights.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Flight List
                </a>
            </div>

            <form action="{{ route('admin.flights.update', $flight->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Airline Operator <span class="text-danger">*</span></label>
                        <input type="text" name="airline" class="form-control" value="{{ old('airline', $flight->airline) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Flight Number <span class="text-danger">*</span></label>
                        <input type="text" name="flight_number" class="form-control" value="{{ old('flight_number', $flight->flight_number) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Origin City <span class="text-danger">*</span></label>
                        <input type="text" name="origin_city" class="form-control" value="{{ old('origin_city', $flight->origin_city) }}" required list="pak_cities_list_edit">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Destination City <span class="text-danger">*</span></label>
                        <input type="text" name="destination_city" class="form-control" value="{{ old('destination_city', $flight->destination_city) }}" required list="pak_cities_list_edit">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Origin Airport Name & Code <span class="text-danger">*</span></label>
                        <input type="text" name="origin_airport" class="form-control" value="{{ old('origin_airport', $flight->origin_airport) }}" required list="pak_airports_list_edit">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Destination Airport Name & Code <span class="text-danger">*</span></label>
                        <input type="text" name="destination_airport" class="form-control" value="{{ old('destination_airport', $flight->destination_airport) }}" required list="pak_airports_list_edit">
                    </div>

                    <datalist id="pak_cities_list_edit">
                        @foreach(config('airports.pakistan', []) as $ap)
                            <option value="{{ $ap['city'] }}">{{ $ap['code'] }}</option>
                        @endforeach
                    </datalist>

                    <datalist id="pak_airports_list_edit">
                        @foreach(config('airports.pakistan', []) as $ap)
                            <option value="{{ $ap['name'] }} ({{ $ap['code'] }})">{{ $ap['city'] }}</option>
                        @endforeach
                    </datalist>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Departure Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="departure_time" class="form-control" value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Arrival Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="arrival_time" class="form-control" value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Duration <span class="text-danger">*</span></label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration', $flight->duration) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Seat Class <span class="text-danger">*</span></label>
                        <select name="seat_class" class="form-select" required>
                            <option value="Economy" {{ $flight->seat_class === 'Economy' ? 'selected' : '' }}>Economy</option>
                            <option value="Business" {{ $flight->seat_class === 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="First Class" {{ $flight->seat_class === 'First Class' ? 'selected' : '' }}>First Class</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Fare per Seat (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_per_seat" class="form-control" value="{{ old('price_per_seat', $flight->price_per_seat) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Total Capacity Seats <span class="text-danger">*</span></label>
                        <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats', $flight->total_seats) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Available Seats <span class="text-danger">*</span></label>
                        <input type="number" name="available_seats" class="form-control" value="{{ old('available_seats', $flight->available_seats) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Flight Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="scheduled" {{ $flight->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="delayed" {{ $flight->status === 'delayed' ? 'selected' : '' }}>Delayed</option>
                            <option value="completed" {{ $flight->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $flight->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Aircraft Model</label>
                        <input type="text" name="aircraft_type" class="form-control" value="{{ old('aircraft_type', $flight->aircraft_type) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Baggage Allowance Policy</label>
                        <input type="text" name="baggage_allowance" class="form-control" value="{{ old('baggage_allowance', $flight->baggage_allowance) }}">
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Flight Information
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
