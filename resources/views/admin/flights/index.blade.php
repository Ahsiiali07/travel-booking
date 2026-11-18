@extends('layouts.admin')

@section('title', 'Manage Flights')
@section('page_title', 'Scheduled Airline Flights')

@section('content')
<div class="card-admin mb-4">
    <div class="card-admin-header flex-wrap gap-2">
        <form action="{{ route('admin.flights.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search airline, flight no, origin, dest..." value="{{ request('search') }}" style="width: 270px;">
            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="delayed" {{ request('status') == 'delayed' ? 'selected' : '' }}>Delayed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>

        <a href="{{ route('admin.flights.create') }}" class="btn btn-sm btn-success">
            <i class="fa-solid fa-plus me-1"></i> Add New Flight
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Flight No.</th>
                    <th>Airline</th>
                    <th>Route</th>
                    <th>Departure / Arrival</th>
                    <th>Seats (Available / Total)</th>
                    <th>Fare / Seat</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flights as $flight)
                    <tr>
                        <td>
                            <span class="badge bg-primary font-monospace fs-6">{{ $flight->flight_number }}</span>
                            <div class="small text-muted">{{ $flight->seat_class }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $flight->airline }}</div>
                            <div class="small text-muted">{{ $flight->aircraft_type }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $flight->origin_city }} &rarr; {{ $flight->destination_city }}</div>
                            <div class="small text-muted">{{ $flight->duration }}</div>
                        </td>
                        <td>
                            <div class="small fw-semibold text-dark">{{ $flight->departure_time->format('d M, h:i A') }}</div>
                            <div class="small text-muted">Arr: {{ $flight->arrival_time->format('h:i A') }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $flight->available_seats > 10 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                {{ $flight->available_seats }} / {{ $flight->total_seats }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark">PKR {{ number_format($flight->price_per_seat) }}</td>
                        <td>
                            @if($flight->status === 'scheduled')
                                <span class="badge bg-success">Scheduled</span>
                            @elseif($flight->status === 'delayed')
                                <span class="badge bg-warning">Delayed</span>
                            @elseif($flight->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($flight->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.flights.show', $flight->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="View Flight">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.flights.edit', $flight->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Flight">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.flights.destroy', $flight->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete flight: {{ $flight->flight_number }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Flight">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No flight schedules registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $flights->links('pagination::bootstrap-5') }}</div>
@endsection
