@extends('layouts.admin')

@section('title', 'Package Details: ' . $package->name)
@section('page_title', 'Vacation Package Overview')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Package List
    </a>
    <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Package
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card-admin p-4">
            <img src="{{ $package->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80' }}" class="w-100 rounded-3 mb-3" style="height: 220px; object-fit: cover;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-primary-subtle text-primary">{{ $package->duration_days }}D / {{ $package->duration_nights }}N</span>
                @if($package->is_featured)
                    <span class="badge bg-warning text-dark">Featured</span>
                @endif
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $package->name }}</h4>
            <div class="small text-muted mb-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $package->destination }}, {{ $package->country }}</div>

            <div class="p-3 bg-light rounded-3 mb-3">
                <div class="d-flex justify-content-between">
                    <span>Base Price:</span>
                    <strong>PKR {{ number_format($package->price) }}</strong>
                </div>
                <div class="d-flex justify-content-between text-success">
                    <span>Discount:</span>
                    <strong>{{ $package->discount_percent }}% OFF</strong>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                    <span class="fw-bold">Final Price / Person:</span>
                    <strong class="text-primary fs-5">PKR {{ number_format($package->final_price) }}</strong>
                </div>
            </div>

            <div class="small text-muted mb-3">{{ $package->description }}</div>

            @if($package->hotel)
                <div class="p-2 border rounded-2 mb-2 small">
                    <div class="text-muted fw-bold">Hotel Partner:</div>
                    <div class="fw-semibold text-dark">{{ $package->hotel->name }} ({{ $package->hotel->city }})</div>
                </div>
            @endif

            @if($package->flight)
                <div class="p-2 border rounded-2 mb-2 small">
                    <div class="text-muted fw-bold">Flight Option:</div>
                    <div class="fw-semibold text-dark">{{ $package->flight->airline }} ({{ $package->flight->flight_number }})</div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card-admin">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-dark">Bookings on this Package ({{ $package->reservations->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Customer</th>
                            <th>Travelers</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($package->reservations as $res)
                            <tr>
                                <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $res->contact_name }}</div>
                                    <div class="small text-muted">{{ $res->contact_phone }}</div>
                                </td>
                                <td>{{ $res->guests_count }} Persons</td>
                                <td class="fw-bold">PKR {{ number_format($res->total_amount) }}</td>
                                <td>
                                    <span class="badge {{ $res->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No reservations booked on this package yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
