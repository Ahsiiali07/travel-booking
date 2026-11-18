@extends('layouts.admin')

@section('title', 'Manage Reservations')
@section('page_title', 'All User Reservations & Bookings')

@section('content')
<div class="card-admin mb-4">
    <!-- Filters Bar -->
    <div class="card-admin-header flex-wrap gap-2">
        <form action="{{ route('admin.reservations.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Ref, customer name, email..." value="{{ request('search') }}" style="width: 220px;">
            <select name="type" class="form-select form-select-sm" style="width: 130px;">
                <option value="">All Services</option>
                <option value="flight" {{ request('type') == 'flight' ? 'selected' : '' }}>Flight</option>
                <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="package" {{ request('type') == 'package' ? 'selected' : '' }}>Package</option>
            </select>
            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Statuses</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <select name="payment_status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">Payment Status</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            @if(request()->hasAny(['search', 'type', 'status', 'payment_status']))
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Booking Ref</th>
                    <th>Customer Name</th>
                    <th>Service Item</th>
                    <th>Type</th>
                    <th>Dates / Schedule</th>
                    <th>Total Fare</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td class="font-monospace fw-bold text-primary">{{ $res->booking_reference }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->contact_name }}</div>
                            <div class="small text-muted">{{ $res->contact_email }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $res->item_name }}</div>
                            <div class="small text-muted">{{ $res->guests_count }} {{ Str::plural('Guest', $res->guests_count) }}</div>
                        </td>
                        <td>
                            @if($res->type === 'flight')
                                <span class="badge badge-soft-primary"><i class="fa-solid fa-plane me-1"></i> Flight</span>
                            @elseif($res->type === 'hotel')
                                <span class="badge badge-soft-warning"><i class="fa-solid fa-hotel me-1"></i> Hotel</span>
                            @else
                                <span class="badge badge-soft-success"><i class="fa-solid fa-umbrella-beach me-1"></i> Package</span>
                            @endif
                        </td>
                        <td class="small">
                            @if($res->type === 'hotel')
                                {{ $res->check_in_date?->format('d M') }} - {{ $res->check_out_date?->format('d M Y') }}
                            @else
                                {{ $res->travel_date?->format('d M Y') ?: 'Scheduled' }}
                            @endif
                        </td>
                        <td class="fw-bold text-dark">PKR {{ number_format($res->total_amount) }}</td>
                        <td>
                            @if($res->payment_status === 'paid')
                                <span class="badge bg-success-subtle text-success">Paid</span>
                            @elseif($res->payment_status === 'refunded')
                                <span class="badge bg-danger-subtle text-danger">Refunded</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            @if($res->status === 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($res->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @elseif($res->status === 'completed')
                                <span class="badge bg-info">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($res->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.reservations.show', $res->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="Inspect">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.reservations.edit', $res->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Update Status">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Delete reservation #{{ $res->booking_reference }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No reservations matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $reservations->links('pagination::bootstrap-5') }}</div>
@endsection
