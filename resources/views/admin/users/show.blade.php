@extends('layouts.admin')

@section('title', 'User Profile: ' . $user->name)
@section('page_title', 'User Details & History')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to User List
    </a>
</div>

<div class="row g-4 mb-4">
    <!-- User Overview Card -->
    <div class="col-lg-4">
        <div class="card-admin p-4 text-center">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-size: 1.8rem; font-weight: 700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
            <div class="text-muted small mb-2">{{ $user->email }}</div>

            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">{{ strtoupper($user->role) }}</span>
                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">{{ strtoupper($user->status) }}</span>
            </div>

            <hr>
            <div class="text-start small text-muted d-flex flex-column gap-2">
                <div><i class="fa-solid fa-phone me-2 text-primary"></i> <strong>Phone:</strong> {{ $user->phone ?: 'N/A' }}</div>
                <div><i class="fa-solid fa-city me-2 text-primary"></i> <strong>City:</strong> {{ $user->city ?: 'N/A' }}</div>
                <div><i class="fa-solid fa-location-dot me-2 text-primary"></i> <strong>Address:</strong> {{ $user->address ?: 'N/A' }}</div>
                <div><i class="fa-solid fa-calendar me-2 text-primary"></i> <strong>Joined:</strong> {{ $user->created_at->format('d M, Y') }}</div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary w-100 btn-sm">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit User Info
                </a>
            </div>
        </div>
    </div>

    <!-- Booking History -->
    <div class="col-lg-8">
        <div class="card-admin">
            <div class="card-admin-header">
                <h6 class="fw-bold mb-0 text-dark">Reservation History ({{ $user->reservations->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->reservations as $res)
                            <tr>
                                <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $res->item_name }}</div>
                                    <span class="badge bg-light text-muted border text-uppercase">{{ $res->type }}</span>
                                </td>
                                <td class="fw-bold">PKR {{ number_format($res->total_amount) }}</td>
                                <td>
                                    <span class="badge {{ $res->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                        {{ ucfirst($res->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $res->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $res->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No reservations found for this user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
