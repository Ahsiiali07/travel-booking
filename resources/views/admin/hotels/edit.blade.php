@extends('layouts.admin')

@section('title', 'Edit Hotel: ' . $hotel->name)
@section('page_title', 'Update Hotel Listing')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Edit Hotel: {{ $hotel->name }}</h5>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Hotel List
                </a>
            </div>

            <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Hotel Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $hotel->name) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $hotel->city) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $hotel->country) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Street Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $hotel->address) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Star Rating <span class="text-danger">*</span></label>
                        <select name="star_rating" class="form-select" required>
                            <option value="5" {{ $hotel->star_rating == 5 ? 'selected' : '' }}>5 Stars Luxury</option>
                            <option value="4" {{ $hotel->star_rating == 4 ? 'selected' : '' }}>4 Stars Premium</option>
                            <option value="3" {{ $hotel->star_rating == 3 ? 'selected' : '' }}>3 Stars Comfort</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Price per Night (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', $hotel->price_per_night) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Total Rooms <span class="text-danger">*</span></label>
                        <input type="number" name="total_rooms" class="form-control" value="{{ old('total_rooms', $hotel->total_rooms) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Available Rooms <span class="text-danger">*</span></label>
                        <input type="number" name="available_rooms" class="form-control" value="{{ old('available_rooms', $hotel->available_rooms) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Room Types (comma separated)</label>
                        <input type="text" name="room_types" class="form-control" value="{{ old('room_types', is_array($hotel->room_types) ? implode(', ', $hotel->room_types) : $hotel->room_types) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Listing Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $hotel->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $hotel->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $hotel->contact_phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $hotel->contact_email) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Image URL</label>
                        <input type="text" name="image" class="form-control" value="{{ old('image', $hotel->image) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Description & Overview</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $hotel->description) }}</textarea>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
