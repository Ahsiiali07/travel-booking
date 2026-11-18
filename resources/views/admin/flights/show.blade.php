@extends('layouts.admin')

@section('title', 'Flight Details: ' . $flight->flight_number)
@section('page_title', 'Flight Profile & Passenger Bookings')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.flights.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Flight List
    </a>
    <a href="{{ route('admin.flights.edit', $flight->id) }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Flight
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-primary fs-6">{{ $flight->flight_number }}</span>
                <span class="badge {{ $flight->status === 'scheduled' ? 'bg-success' : 'bg-warning' }} text-uppercase">{{ $flight->status }}</span>
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $flight->airline }}</h4>
            <div class="small text-muted mb-3">Model: <strong>{{ $flight->aircraft_type }}</strong> &bull; Class: {{ $flight->seat_class }}</div>

            <div class="p-3 bg-light rounded-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold fs-5 text-dark">{{ $flight->origin_city }}</div>
                        <div class="small text-muted">{{ $flight->departure_time->format('d M, h:i A') }}</div>
                    </div>
                    <div class="text-center px-2">
                        <i class="fa-solid fa-plane text-primary"></i>
                        <div class="small text-muted" style="font-size: 0.72rem;">{{ $flight->duration }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold fs-5 text-dark">{{ $flight->destination_city }}</div>
                        <div class="small text-muted">{{ $flight->arrival_time->format('d M, h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="row g-2 mb-3 text-center">
                <div class="col-6">
                    <div class="p-2 border rounded-2 bg-white">
                        <span class="small text-muted d-block">Price / Seat</span>
                        <strong class="text-primary fs-5">PKR {{ number_format($flight->price_per_seat) }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 border rounded-2 bg-white">
                        <span class="small text-muted d-block">Available Seats</span>
                        <strong class="text-success fs-5">{{ $flight->available_seats }} / {{ $flight->total_seats }}</strong>
                    </div>
                </div>
            </div>

            <div class="small text-muted border-top pt-2">
                <div><strong>Origin Airport:</strong> {{ $flight->origin_airport }}</div>
                <div><strong>Destination Airport:</strong> {{ $flight->destination_airport }}</div>
                <div><strong>Baggage Allowance:</strong> {{ $flight->baggage_allowance }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card-admin">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-dark">Booked Passenger Schedules ({{ $flight->reservations->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Contact</th>
                            <th>Seats</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($flight->reservations as $res)
                            <tr>
                                <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $res->contact_name }}</div>
                                    <div class="small text-muted">{{ $res->contact_phone }}</div>
                                </td>
                                <td>{{ $res->guests_count }} Seats</td>
                                <td class="fw-bold">PKR {{ number_format($res->total_amount) }}</td>
                                <td>
                                    <span class="badge {{ $res->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No reservations booked on this flight yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
