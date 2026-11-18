@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Overview')

@section('content')
<!-- Top Greeting & Action (Figma Make Style) -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
    <div>
        <h2 class="fw-bold tracking-tight text-dark mb-1" style="font-size: 1.75rem;">Good day, {{ auth()->user()->name }}</h2>
        <p class="text-muted small mb-0">Here's what's happening with your travel business and active reservations.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-primary-custom btn-sm px-4">
            <i class="fa-solid fa-plus me-1"></i> Manage Bookings
        </a>
    </div>
</div>

<!-- 4 Key Stat Cards (Figma Make Layout) -->
<div class="row g-3 mb-4">
    <!-- Total Bookings -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb;">
                    <i class="fa-solid fa-briefcase fs-5"></i>
                </div>
                <span class="badge rounded-pill fw-bold" style="background: #ecfdf5; color: #059669; font-size: 0.72rem;">+12.5%</span>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['total_bookings'] }}</h3>
            <p class="text-muted small mb-0">Total Bookings Recorded</p>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ecfdf5; color: #059669;">
                    <i class="fa-solid fa-credit-card fs-5"></i>
                </div>
                <span class="badge rounded-pill fw-bold" style="background: #ecfdf5; color: #059669; font-size: 0.72rem;">+8.2%</span>
            </div>
            <h3 class="fw-bold text-dark mb-1">PKR {{ number_format($stats['total_revenue']) }}</h3>
            <p class="text-muted small mb-0">Confirmed Revenue</p>
        </div>
    </div>

    <!-- Active Travelers / Registered Users -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #f5f3ff; color: #7c3aed;">
                    <i class="fa-solid fa-users fs-5"></i>
                </div>
                <span class="badge rounded-pill fw-bold" style="background: #ecfdf5; color: #059669; font-size: 0.72rem;">+6.4%</span>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['total_users'] }}</h3>
            <p class="text-muted small mb-0">Registered Travelers</p>
        </div>
    </div>

    <!-- Pending Refunds / Requests -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-stat h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fff0ec; color: #e54e2e;">
                    <i class="fa-solid fa-calendar-check fs-5"></i>
                </div>
                <span class="badge rounded-pill fw-bold" style="background: #fff0ec; color: #e54e2e; font-size: 0.72rem;">
                    {{ $stats['pending_refunds'] > 0 ? 'Needs Attention' : 'All Clear' }}
                </span>
            </div>
            <h3 class="fw-bold text-dark mb-1">{{ $stats['pending_refunds'] }}</h3>
            <p class="text-muted small mb-0">Pending Refund Claims</p>
        </div>
    </div>
</div>

<!-- Middle Section: Revenue Chart & Top Destination Card (Figma Make Style) -->
<div class="row g-4 mb-4">
    <!-- Left: Revenue Overview Bar Simulation -->
    <div class="col-xl-8">
        <div class="card-admin h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Revenue Overview</h5>
                    <p class="small text-muted mb-0">Monthly booking performance for the current academic session</p>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">FYP Session 2026</span>
            </div>

            <!-- Stylized Figma Bar Chart -->
            <div class="d-flex align-items-end justify-content-between gap-2 border-bottom pb-2" style="height: 190px;">
                @php
                    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    $heights = [36, 52, 45, 68, 58, 80, 72, 90, 78, 85, 96, 60];
                @endphp
                @foreach($months as $idx => $m)
                    <div class="flex-grow-1 d-flex flex-column align-items-center h-100 justify-content-end">
                        <div class="w-100 rounded-top transition-all" 
                             style="height: {{ $heights[$idx] }}%; background-color: {{ $idx === 10 ? '#ff6b4a' : '#dce8ee' }}; border-top-left-radius: 6px; border-top-right-radius: 6px;"
                             title="{{ $m }}: PKR {{ number_format($heights[$idx] * 1850) }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-between text-muted small pt-2" style="font-size: 0.75rem;">
                @foreach($months as $m)
                    <span class="text-center" style="flex: 1;">{{ $m }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right: Top Destination Card (Figma Deep Navy Section) -->
    <div class="col-xl-4">
        <div class="card border-0 rounded-4 overflow-hidden h-100 text-white p-4 d-flex flex-column justify-content-between" style="background-color: #102d45;">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p class="small text-white-50 text-uppercase tracking-wider mb-1" style="font-size: 0.72rem;">Top Destination</p>
                        <h4 class="fw-bold mb-0 text-white">Hunza Valley</h4>
                    </div>
                    <span class="badge rounded-pill bg-white bg-opacity-20 text-white px-3 py-1">Pakistan</span>
                </div>
                
                <div class="rounded-3 overflow-hidden my-3" style="height: 130px;">
                    <img src="https://images.unsplash.com/photo-1779831859141-452040bc1463?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Hunza Valley">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <div>
                    <h3 class="fw-bold text-white mb-0">{{ $stats['total_packages'] }}</h3>
                    <p class="text-white-50 small mb-0">Active Tour Packages</p>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="rounded-circle d-flex align-items-center justify-content-center text-white text-decoration-none shadow" style="width: 44px; height: 44px; background-color: #ff6b4a;">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table (Figma Make Style) -->
<div class="card-admin mb-4">
    <div class="card-admin-header">
        <div>
            <h5 class="fw-bold text-dark mb-0">Recent Bookings</h5>
            <p class="text-muted small mb-0">Latest customer reservation activity</p>
        </div>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-custom rounded-pill px-3">
            View All Bookings <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Service & Reference</th>
                    <th>Customer</th>
                    <th>Travel Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservations as $res)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                                     style="width: 38px; height: 38px; background: {{ $res->type === 'flight' ? '#eff6ff' : ($res->type === 'hotel' ? '#f5f3ff' : '#fff0ec') }}; color: {{ $res->type === 'flight' ? '#2563eb' : ($res->type === 'hotel' ? '#7c3aed' : '#e54e2e') }};">
                                    <i class="fa-solid {{ $res->type === 'flight' ? 'fa-plane' : ($res->type === 'hotel' ? 'fa-hotel' : 'fa-umbrella-beach') }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $res->item_name }}</div>
                                    <span class="font-monospace text-muted small" style="font-size: 0.75rem;">{{ $res->booking_reference }} &bull; {{ ucfirst($res->type) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $res->contact_name }}</div>
                            <div class="text-muted small">{{ $res->contact_email }}</div>
                        </td>
                        <td>
                            <div class="small fw-semibold text-dark">
                                @if($res->type === 'hotel')
                                    {{ $res->check_in_date?->format('M d, Y') }}
                                @else
                                    {{ $res->travel_date?->format('M d, Y') ?: 'Scheduled' }}
                                @endif
                            </div>
                        </td>
                        <td class="fw-bold text-dark">PKR {{ number_format($res->total_amount) }}</td>
                        <td>
                            @if($res->status === 'confirmed')
                                <span class="badge" style="background: #ecfdf5; color: #047857; border-radius: 9999px; padding: 0.35rem 0.75rem;">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 0.45rem;"></i> Confirmed
                                </span>
                            @elseif($res->status === 'cancelled')
                                <span class="badge" style="background: #fef2f2; color: #dc2626; border-radius: 9999px; padding: 0.35rem 0.75rem;">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 0.45rem;"></i> Cancelled
                                </span>
                            @else
                                <span class="badge" style="background: #fffbeb; color: #b45309; border-radius: 9999px; padding: 0.35rem 0.75rem;">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 0.45rem;"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.reservations.show', $res->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3" title="Inspect Booking">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            No reservations recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
