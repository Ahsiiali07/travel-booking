@extends('layouts.app')

@section('title', 'My Travel Dashboard')

@section('content')
<div class="container py-4">
    <!-- Welcome Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-muted small mb-0">Manage your scheduled flights, hotel stays, vacation tours, and invoices</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('search') }}" class="btn btn-primary-custom btn-sm">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Book New Service
            </a>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-custom btn-sm rounded-pill px-3">
                <i class="fa-solid fa-user-gear me-1"></i> Profile
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Flight Schedules</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #eff6ff; color: #2563eb;">
                        <i class="fa-solid fa-plane fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['flight_schedules'] }}</h3>
                <a href="{{ route('user.flight-schedules.index') }}" class="small text-decoration-none mt-2 d-inline-block fw-semibold" style="color: #ff6b4a;">View Schedules &rarr;</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Hotel Stays</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f5f3ff; color: #7c3aed;">
                        <i class="fa-solid fa-hotel fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['hotel_schedules'] }}</h3>
                <a href="{{ route('user.hotel-schedules.index') }}" class="small text-decoration-none mt-2 d-inline-block fw-semibold" style="color: #ff6b4a;">View Hotels &rarr;</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Tour Packages</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #fff0ec; color: #e54e2e;">
                        <i class="fa-solid fa-umbrella-beach fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $stats['package_bookings'] }}</h3>
                <a href="{{ route('user.package-bookings.index') }}" class="small text-decoration-none mt-2 d-inline-block fw-semibold" style="color: #ff6b4a;">View Packages &rarr;</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Amount Paid</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #ecfdf5; color: #059669;">
                        <i class="fa-solid fa-receipt fs-5"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-0">PKR {{ number_format($stats['total_spent']) }}</h4>
                <a href="{{ route('user.payments.index') }}" class="small text-decoration-none mt-2 d-inline-block fw-semibold" style="color: #ff6b4a;">Payment History &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Quick Services Navigation Shortcuts -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 border shadow-sm d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold text-dark mb-1">Flights Management</h6>
                    <p class="small text-muted mb-0">Create, view tickets or cancel schedules</p>
                </div>
                <a href="{{ route('user.flight-schedules.index') }}" class="btn btn-sm btn-outline-custom rounded-pill">Manage</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 border shadow-sm d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold text-dark mb-1">Hotels Management</h6>
                    <p class="small text-muted mb-0">View vouchers or modify room bookings</p>
                </div>
                <a href="{{ route('user.hotel-schedules.index') }}" class="btn btn-sm btn-outline-warning rounded-pill text-dark">Manage</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-4 border shadow-sm d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold text-dark mb-1">Refund Claims</h6>
                    <p class="small text-muted mb-0">{{ $stats['pending_refunds'] }} pending review</p>
                </div>
                <a href="{{ route('user.refunds.index') }}" class="btn btn-sm btn-outline-danger rounded-pill">Refunds</a>
            </div>
        </div>
    </div>

    <!-- Recent Reservations Table -->
    <div class="card card-custom border-0 shadow-sm">
        <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i> Recent Reservations & Schedules</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th class="ps-4">Reference</th>
                        <th>Service / Type</th>
                        <th>Details</th>
                        <th>Travel / Stay Date</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Booking Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $res)
                        <tr>
                            <td class="ps-4 fw-bold text-primary font-monospace">{{ $res->booking_reference }}</td>
                            <td>
                                @if($res->type === 'flight')
                                    <span class="badge badge-soft-primary"><i class="fa-solid fa-plane me-1"></i> Flight</span>
                                @elseif($res->type === 'hotel')
                                    <span class="badge badge-soft-warning"><i class="fa-solid fa-hotel me-1"></i> Hotel</span>
                                @else
                                    <span class="badge badge-soft-success"><i class="fa-solid fa-umbrella-beach me-1"></i> Package</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $res->item_name }}</div>
                                <div class="small text-muted">{{ $res->guests_count }} {{ Str::plural('Guest', $res->guests_count) }}</div>
                            </td>
                            <td class="small text-muted">
                                @if($res->type === 'hotel')
                                    {{ $res->check_in_date?->format('d M') }} to {{ $res->check_out_date?->format('d M Y') }}
                                @else
                                    {{ $res->travel_date?->format('d M Y') ?: 'Confirmed' }}
                                @endif
                            </td>
                            <td class="fw-bold text-dark">PKR {{ number_format($res->total_amount) }}</td>
                            <td>
                                @if($res->payment_status === 'paid')
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check me-1"></i> Paid</span>
                                @elseif($res->payment_status === 'refunded')
                                    <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-rotate-left me-1"></i> Refunded</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-clock me-1"></i> Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if($res->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($res->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($res->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2 align-items-center">
                                    @if($res->payment_status === 'unpaid')
                                        <a href="{{ route('user.checkout', $res->id) }}" class="btn-book-figma py-1 px-3" title="Pay Now">
                                            <i class="fa-solid fa-credit-card"></i> Pay Now
                                        </a>
                                    @else
                                        <a href="{{ route('user.invoice', $res->id) }}" class="btn-detail-figma py-1 px-2" title="View Invoice">
                                            <i class="fa-solid fa-file-invoice"></i> Invoice
                                        </a>
                                    @endif

                                    @if($res->type === 'flight')
                                        <a href="{{ route('user.flight-schedules.show', $res->id) }}" class="btn-detail-figma py-1 px-2" title="View Ticket">
                                            <i class="fa-solid fa-ticket"></i> Ticket
                                        </a>
                                    @elseif($res->type === 'hotel')
                                        <a href="{{ route('user.hotel-schedules.show', $res->id) }}" class="btn-detail-figma py-1 px-2" title="View Voucher">
                                            <i class="fa-solid fa-hotel"></i> Voucher
                                        </a>
                                    @else
                                        <a href="{{ route('user.package-bookings.show', $res->id) }}" class="btn-detail-figma py-1 px-2" title="View Tour Voucher">
                                            <i class="fa-solid fa-map-location-dot"></i> Voucher
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No reservations made yet. <a href="{{ route('home') }}">Start exploring destinations</a>!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
