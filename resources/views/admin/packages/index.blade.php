@extends('layouts.admin')

@section('title', 'Manage Packages')
@section('page_title', 'Vacation Tour Packages')

@section('content')
<div class="card-admin mb-4">
    <div class="card-admin-header flex-wrap gap-2">
        <form action="{{ route('admin.packages.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search package name, destination..." value="{{ request('search') }}" style="width: 250px;">
            <select name="status" class="form-select form-select-sm" style="width: 130px;">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>

        <a href="{{ route('admin.packages.create') }}" class="btn btn-sm btn-success">
            <i class="fa-solid fa-plus me-1"></i> Create Vacation Package
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Price / Person</th>
                    <th>Discount</th>
                    <th>Slots Open</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $pkg)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $pkg->image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=100&q=80' }}" class="rounded-2" width="45" height="38" style="object-fit: cover;">
                                <div class="fw-bold text-dark">{{ $pkg->name }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $pkg->destination }}</div>
                            <div class="small text-muted">{{ $pkg->country }}</div>
                        </td>
                        <td>{{ $pkg->duration_days }}D / {{ $pkg->duration_nights }}N</td>
                        <td class="fw-bold text-dark">
                            PKR {{ number_format($pkg->final_price) }}
                            @if($pkg->discount_percent > 0)
                                <div class="text-muted text-decoration-line-through small" style="font-size: 0.75rem;">PKR {{ number_format($pkg->price) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($pkg->discount_percent > 0)
                                <span class="badge bg-danger">{{ $pkg->discount_percent }}% OFF</span>
                            @else
                                <span class="text-muted small">None</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info-subtle text-info">{{ $pkg->available_slots }} / {{ $pkg->max_capacity }}</span>
                        </td>
                        <td>
                            @if($pkg->is_featured)
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i> Yes</span>
                            @else
                                <span class="text-muted small">No</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $pkg->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($pkg->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.packages.show', $pkg->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Package">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete package: {{ $pkg->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Package">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No vacation packages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $packages->links('pagination::bootstrap-5') }}</div>
@endsection
