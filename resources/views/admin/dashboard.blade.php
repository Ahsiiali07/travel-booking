@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Analytics & Operational Overview')

@section('content')
<!-- KPI Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Total Revenue</span>
                <div class="bg-success-subtle text-success p-2 rounded-3"><i class="fa-solid fa-coins fs-5"></i></div>
            </div>
            <h3 class="fw-bold text-dark mb-1">PKR {{ number_format($stats['total_revenue']) }}</h3>
            <span class="small text-success"><i class="fa-solid fa-arrow-up me-1"></i> Confirmed Transactions</span>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Total Bookings</span>
                <div class="bg-primary-subtle text-primary p-2 rounded-3"><i class="fa-solid fa-ticket fs-5"></i></div>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['total_bookings'] }}</h3>
            <span class="small text-muted">{{ $stats['confirmed_bookings'] }} confirmed reservations</span>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Registered Users</span>
                <div class="bg-info-subtle text-info p-2 rounded-3"><i class="fa-solid fa-users fs-5"></i></div>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['total_users'] }}</h3>
            <span class="small text-info"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Manage Users &rarr;</a></span>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-stat">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Pending Refunds</span>
                <div class="bg-danger-subtle text-danger p-2 rounded-3"><i class="fa-solid fa-rotate-left fs-5"></i></div>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['pending_refunds'] }}</h3>
            <span class="small text-danger"><a href="{{ route('admin.refunds.index') }}" class="text-danger text-decoration-none">Requires Attention &rarr;</a></span>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white p-2 rounded-2"><i class="fa-solid fa-plane"></i></div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $stats['total_flights'] }} Flights</h5>
                    <div class="small text-muted">Scheduled routes active</div>
                </div>
            </div>
            <a href="{{ route('admin.flights.index') }}" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning text-dark p-2 rounded-2"><i class="fa-solid fa-hotel"></i></div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $stats['total_hotels'] }} Hotels</h5>
                    <div class="small text-muted">Partner properties listed</div>
                </div>
            </div>
            <a href="{{ route('admin.hotels.index') }}" class="btn btn-sm btn-outline-warning text-dark">Manage</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success text-white p-2 rounded-2"><i class="fa-solid fa-umbrella-beach"></i></div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $stats['total_packages'] }} Packages</h5>
                    <div class="small text-muted">Curated vacation packages</div>
                </div>
            </div>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-success">Manage</a>
        </div>
    </div>
</div>

<!-- Recent Reservations & Pending Refunds -->
<div class="row g-4 mb-4">
    <!-- Recent Reservations (Left) -->
    <div class="col-lg-8">
        <div class="card-admin h-100">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i> Recent User Reservations</h6>
                <a href="{{ route('admin.reservations.index') }}" class="small text-decoration-none">View All Reservations &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReservations as $res)
                            <tr>
                                <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $res->contact_name }}</div>
                                    <div class="small text-muted">{{ $res->contact_email }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-soft-{{ $res->type === 'flight' ? 'primary' : ($res->type === 'hotel' ? 'warning' : 'success') }} text-uppercase">
                                        {{ $res->type }}
                                    </span>
                                </td>
                                <td class="fw-bold">PKR {{ number_format($res->total_amount) }}</td>
                                <td>
                                    <span class="badge {{ $res->status === 'confirmed' ? 'bg-success' : ($res->status === 'cancelled' ? 'bg-danger' : 'bg-secondary') }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.reservations.show', $res->id) }}" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Inspect">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No reservations recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Refunds (Right) -->
    <div class="col-lg-4">
        <div class="card-admin h-100">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-danger"><i class="fa-solid fa-rotate-left me-2"></i> Pending Refund Requests</h6>
                <a href="{{ route('admin.refunds.index') }}" class="small text-decoration-none">Manage &rarr;</a>
            </div>
            <div class="p-3">
                @forelse($pendingRefundRequests as $ref)
                    <div class="p-3 border rounded-3 mb-2 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold font-monospace text-primary small">{{ $ref->refund_reference }}</span>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                        <div class="fw-bold text-dark small">{{ $ref->user?->name ?: 'Customer' }}</div>
                        <div class="text-muted small">Amount: <strong>PKR {{ number_format($ref->amount) }}</strong></div>
                        <div class="small text-muted text-truncate mt-1">Reason: {{ $ref->reason }}</div>
                        <div class="mt-2 text-end">
                            <a href="{{ route('admin.refunds.edit', $ref->id) }}" class="btn btn-sm btn-outline-danger py-1 px-2">
                                Review & Process
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        <i class="fa-solid fa-circle-check fs-2 text-success mb-2"></i>
                        <p class="mb-0">No pending refund claims!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
