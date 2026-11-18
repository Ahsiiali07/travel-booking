@extends('layouts.app')

@section('title', 'My Flight Schedules')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Flight Schedules</h2>
            <p class="text-muted small">View, print boarding passes, or manage cancellations for your airline reservations</p>
        </div>
        <a href="{{ route('flights.index') }}" class="btn btn-primary-custom btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Schedule New Flight
        </a>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Booking Ref</th>
                        <th>Airline / Flight</th>
                        <th>Route</th>
                        <th>Travel Date</th>
                        <th>Passengers</th>
                        <th>Total Fare</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flightSchedules as $schedule)
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-primary">{{ $schedule->booking_reference }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $schedule->flight ? $schedule->flight->airline : 'Flight Reservation' }}</div>
                                <span class="badge bg-secondary-subtle text-secondary small">{{ $schedule->flight?->flight_number }}</span>
                                <span class="badge bg-info-subtle text-info small ms-1">{{ $schedule->seat_class }}</span>
                            </td>
                            <td>
                                @if($schedule->flight)
                                    <div class="fw-semibold text-dark">{{ $schedule->flight->origin_city }} &rarr; {{ $schedule->flight->destination_city }}</div>
                                    <div class="small text-muted">{{ $schedule->flight->duration }}</div>
                                @else
                                    <span class="text-muted">Route Info</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $schedule->travel_date?->format('d M, Y') }}</div>
                                <div class="small text-muted">{{ $schedule->flight?->departure_time->format('h:i A') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $schedule->guests_count }} {{ Str::plural('Seat', $schedule->guests_count) }}</span>
                            </td>
                            <td class="fw-bold text-dark">PKR {{ number_format($schedule->total_amount) }}</td>
                            <td>
                                @if($schedule->payment_status === 'paid')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check me-1"></i> Paid</span>
                                @elseif($schedule->payment_status === 'refunded')
                                    <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-rotate-left me-1"></i> Refunded</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-clock me-1"></i> Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if($schedule->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($schedule->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($schedule->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-1">
                                    @if($schedule->payment_status === 'unpaid')
                                        <a href="{{ route('user.checkout', $schedule->id) }}" class="btn btn-sm btn-success py-1 px-2" title="Complete Payment">
                                            <i class="fa-solid fa-credit-card"></i> Pay
                                        </a>
                                    @endif

                                    <a href="{{ route('user.flight-schedules.show', $schedule->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="View Boarding Pass / Ticket">
                                        <i class="fa-solid fa-ticket"></i> Ticket
                                    </a>

                                    @if($schedule->status !== 'cancelled')
                                        <form action="{{ route('user.flight-schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this flight schedule? If already paid, you can submit a refund request.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Cancel Flight Schedule">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-plane-circle-exclamation fs-2 text-muted mb-2"></i>
                                <p class="mb-2">You haven't scheduled any flights yet.</p>
                                <a href="{{ route('flights.index') }}" class="btn btn-primary-custom btn-sm">Explore Scheduled Flights</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $flightSchedules->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
