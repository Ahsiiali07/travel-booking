@extends('layouts.admin')

@section('title', 'Hotel Details: ' . $hotel->name)
@section('page_title', 'Hotel Profile & Reservations')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.hotels.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Hotel List
    </a>
    <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-primary">
        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Hotel
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card-admin p-4">
            <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' }}" class="w-100 rounded-3 mb-3" style="height: 220px; object-fit: cover;">
            <div class="mb-2">
                @for($i = 0; $i < $hotel->star_rating; $i++)
                    <i class="fa-solid fa-star text-warning"></i>
                @endfor
                <span class="badge bg-primary-subtle text-primary ms-2">{{ $hotel->star_rating }}-Star Property</span>
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $hotel->name }}</h4>
            <div class="small text-muted mb-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}</div>

            <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="small text-muted">Price Per Night</span>
                    <div class="fw-bold fs-5 text-primary">PKR {{ number_format($hotel->price_per_night) }}</div>
                </div>
                <div>
                    <span class="small text-muted">Available Rooms</span>
                    <div class="fw-bold fs-5 text-success">{{ $hotel->available_rooms }} / {{ $hotel->total_rooms }}</div>
                </div>
            </div>

            <div class="small text-muted mb-3">{{ $hotel->description }}</div>

            <div class="border-top pt-2 small text-muted">
                <div><strong>Phone:</strong> {{ $hotel->contact_phone ?: 'N/A' }}</div>
                <div><strong>Email:</strong> {{ $hotel->contact_email ?: 'N/A' }}</div>
                <div><strong>Status:</strong> <span class="badge {{ $hotel->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($hotel->status) }}</span></div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card-admin">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-dark">Recent Bookings for this Hotel ({{ $hotel->reservations->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Guest</th>
                            <th>Stay Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hotel->reservations as $res)
                            <tr>
                                <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $res->contact_name }}</div>
                                    <div class="small text-muted">{{ $res->guests_count }} Guests</div>
                                </td>
                                <td class="small">{{ $res->check_in_date?->format('d M') }} to {{ $res->check_out_date?->format('d M Y') }}</td>
                                <td class="fw-bold">PKR {{ number_format($res->total_amount) }}</td>
                                <td><span class="badge {{ $res->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($res->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No reservations recorded yet for this hotel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
