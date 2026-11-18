@extends('layouts.app')

@section('title', 'My Package Bookings')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Vacation Package Bookings</h2>
            <p class="text-muted small">Access holiday tour itineraries, download booking vouchers, and manage trips</p>
        </div>
        <a href="{{ route('packages.index') }}" class="btn btn-primary-custom btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Browse More Tours
        </a>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Booking Ref</th>
                        <th>Tour Package</th>
                        <th>Destination</th>
                        <th>Departure Date</th>
                        <th>Travelers</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packageBookings as $booking)
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-primary">{{ $booking->booking_reference }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $booking->package ? $booking->package->name : 'Vacation Tour' }}</div>
                                <div class="small text-muted">{{ $booking->package?->duration_days }} Days &bull; {{ $booking->package?->duration_nights }} Nights</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $booking->package?->destination }}</div>
                                <div class="small text-muted">{{ $booking->package?->country }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $booking->travel_date?->format('d M, Y') }}</div>
                                <div class="small text-success">Guaranteed Departure</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $booking->guests_count }} {{ Str::plural('Traveler', $booking->guests_count) }}</span>
                            </td>
                            <td class="fw-bold text-dark">PKR {{ number_format($booking->total_amount) }}</td>
                            <td>
                                @if($booking->payment_status === 'paid')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check me-1"></i> Paid</span>
                                @elseif($booking->payment_status === 'refunded')
                                    <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-rotate-left me-1"></i> Refunded</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-clock me-1"></i> Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2 align-items-center">
                                    @if($booking->payment_status === 'unpaid')
                                        <a href="{{ route('user.checkout', $booking->id) }}" class="btn-book-figma py-1 px-3" title="Complete Payment">
                                            <i class="fa-solid fa-credit-card"></i> Pay Now
                                        </a>
                                    @endif

                                    <a href="{{ route('user.package-bookings.show', $booking->id) }}" class="btn-detail-figma py-1 px-2" title="View Tour Itinerary & Voucher">
                                        <i class="fa-solid fa-map-location-dot"></i> Itinerary
                                    </a>

                                    @if($booking->status !== 'cancelled')
                                        <form action="{{ route('user.package-bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this vacation package booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill py-1 px-2" title="Cancel Booking">
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
                                <i class="fa-solid fa-umbrella-beach fs-2 text-muted mb-2"></i>
                                <p class="mb-2">You haven't booked any holiday packages yet.</p>
                                <a href="{{ route('packages.index') }}" class="btn btn-primary-custom btn-sm">Explore Tour Packages</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $packageBookings->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
