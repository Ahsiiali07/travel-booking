@extends('layouts.app')

@section('title', 'My Hotel Schedules & Stays')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Hotel Schedules</h2>
            <p class="text-muted small">Manage hotel bookings, view check-in vouchers, and request cancellations</p>
        </div>
        <a href="{{ route('hotels.index') }}" class="btn btn-primary-custom btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Book New Hotel
        </a>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Booking Ref</th>
                        <th>Hotel Name</th>
                        <th>City / Location</th>
                        <th>Check-in & Check-out</th>
                        <th>Room & Guests</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hotelSchedules as $schedule)
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-primary">{{ $schedule->booking_reference }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $schedule->hotel ? $schedule->hotel->name : 'Hotel Reservation' }}</div>
                                <div class="small text-muted">
                                    @if($schedule->hotel)
                                        @for($i=0; $i < $schedule->hotel->star_rating; $i++)
                                            <i class="fa-solid fa-star text-warning" style="font-size: 0.7rem;"></i>
                                        @endfor
                                        {{ $schedule->hotel->star_rating }}-Star
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $schedule->hotel?->city ?: 'N/A' }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $schedule->hotel?->address }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ $schedule->check_in_date?->format('d M, Y') }}</div>
                                <div class="small text-muted">to {{ $schedule->check_out_date?->format('d M, Y') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $schedule->room_type ?: 'Standard Room' }}</span>
                                <div class="small text-muted">{{ $schedule->guests_count }} {{ Str::plural('Guest', $schedule->guests_count) }}</div>
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
                                        <a href="{{ route('user.checkout', $schedule->id) }}" class="btn btn-sm btn-success py-1 px-2" title="Pay Now">
                                            <i class="fa-solid fa-credit-card"></i> Pay
                                        </a>
                                    @endif

                                    <a href="{{ route('user.hotel-schedules.show', $schedule->id) }}" class="btn btn-sm btn-outline-warning py-1 px-2 text-dark" title="View Hotel Voucher">
                                        <i class="fa-solid fa-file-lines"></i> Voucher
                                    </a>

                                    @if($schedule->status !== 'cancelled')
                                        <form action="{{ route('user.hotel-schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this hotel reservation?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Cancel Hotel Reservation">
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
                                <i class="fa-solid fa-bed fs-2 text-muted mb-2"></i>
                                <p class="mb-2">No hotel schedules currently booked.</p>
                                <a href="{{ route('hotels.index') }}" class="btn btn-primary-custom btn-sm">Browse Top Hotels</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $hotelSchedules->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
