@extends('layouts.admin')

@section('title', 'Manage Hotels')
@section('page_title', 'Hotel Listings & Details')

@section('content')
<div class="card-admin mb-4">
    <div class="card-admin-header flex-wrap gap-2">
        <form action="{{ route('admin.hotels.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search hotel name or city..." value="{{ request('search') }}" style="width: 250px;">
            <select name="status" class="form-select form-select-sm" style="width: 130px;">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>

        <a href="{{ route('admin.hotels.create') }}" class="btn btn-sm btn-success">
            <i class="fa-solid fa-plus me-1"></i> Add New Hotel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Hotel Name</th>
                    <th>City / Country</th>
                    <th>Star Rating</th>
                    <th>Price / Night</th>
                    <th>Rooms (Available / Total)</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hotels as $hotel)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=100&q=80' }}" class="rounded-2" width="45" height="38" style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-dark">{{ $hotel->name }}</div>
                                    <div class="small text-muted">{{ $hotel->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $hotel->city }}</div>
                            <div class="small text-muted">{{ $hotel->country }}</div>
                        </td>
                        <td>
                            @for($i = 0; $i < $hotel->star_rating; $i++)
                                <i class="fa-solid fa-star text-warning small"></i>
                            @endfor
                            <span class="small text-muted ms-1">({{ $hotel->star_rating }}-Star)</span>
                        </td>
                        <td class="fw-bold text-dark">PKR {{ number_format($hotel->price_per_night) }}</td>
                        <td>
                            <span class="badge {{ $hotel->available_rooms > 5 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                {{ $hotel->available_rooms }} / {{ $hotel->total_rooms }} Available
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $hotel->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($hotel->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.hotels.show', $hotel->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-outline-primary py-1 px-2" title="Edit Hotel">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete hotel: {{ $hotel->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Hotel">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No hotels registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $hotels->links('pagination::bootstrap-5') }}</div>
@endsection
