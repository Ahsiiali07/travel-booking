@extends('layouts.admin')

@section('title', 'Manage Refunds')
@section('page_title', 'Refund Management & Claims')

@section('content')
<div class="card-admin mb-4">
    <div class="card-admin-header flex-wrap gap-2">
        <form action="{{ route('admin.refunds.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search ref, user, booking..." value="{{ request('search') }}" style="width: 250px;">
            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>

        <a href="{{ route('admin.refunds.create') }}" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-plus me-1"></i> Issue Manual Refund
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Refund Ref</th>
                    <th>Booking Ref</th>
                    <th>Customer</th>
                    <th>Claimed Amount</th>
                    <th>Reason</th>
                    <th>Refund Method</th>
                    <th>Status</th>
                    <th>Processed At</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($refunds as $refund)
                    <tr>
                        <td class="font-monospace fw-bold text-danger">{{ $refund->refund_reference }}</td>
                        <td>
                            @if($refund->reservation)
                                <a href="{{ route('admin.reservations.show', $refund->reservation->id) }}" class="font-monospace text-primary text-decoration-none">
                                    {{ $refund->reservation->booking_reference }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $refund->user?->name ?: 'Customer' }}</div>
                            <div class="small text-muted">{{ $refund->user?->email }}</div>
                        </td>
                        <td class="fw-bold text-dark">PKR {{ number_format($refund->amount) }}</td>
                        <td>
                            <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $refund->reason }}</div>
                        </td>
                        <td class="small">{{ ucwords(str_replace('_', ' ', $refund->refund_method)) }}</td>
                        <td>
                            @if($refund->status === 'processed')
                                <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check-double me-1"></i> Processed</span>
                            @elseif($refund->status === 'approved')
                                <span class="badge bg-info-subtle text-info"><i class="fa-solid fa-check me-1"></i> Approved</span>
                            @elseif($refund->status === 'rejected')
                                <span class="badge bg-danger-subtle text-danger"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning"><i class="fa-solid fa-clock me-1"></i> Pending</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $refund->processed_at?->format('d M, Y') ?: '-' }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.refunds.show', $refund->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="Inspect">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.refunds.edit', $refund->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Review / Update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.refunds.destroy', $refund->id) }}" method="POST" onsubmit="return confirm('Delete refund record: {{ $refund->refund_reference }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Refund">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No refund requests recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $refunds->links('pagination::bootstrap-5') }}</div>
@endsection
