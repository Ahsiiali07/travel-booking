@extends('layouts.admin')

@section('title', 'Add New Hotel')
@section('page_title', 'Create Hotel Listing')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Enter Hotel & Room Details</h5>
                <a href="{{ route('admin.hotels.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Hotel List
                </a>
            </div>

            <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Hotel Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Serena Hotel Islamabad">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required placeholder="e.g. Islamabad">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', 'Pakistan') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Street Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required placeholder="Sector, Road, Landmark">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Star Rating <span class="text-danger">*</span></label>
                        <select name="star_rating" class="form-select" required>
                            <option value="5" {{ old('star_rating') == '5' ? 'selected' : '' }}>5 Stars Luxury</option>
                            <option value="4" {{ old('star_rating', '4') == '4' ? 'selected' : '' }}>4 Stars Premium</option>
                            <option value="3" {{ old('star_rating') == '3' ? 'selected' : '' }}>3 Stars Comfort</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Price per Night (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', '15000') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Total Rooms <span class="text-danger">*</span></label>
                        <input type="number" name="total_rooms" class="form-control" value="{{ old('total_rooms', '30') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Available Rooms <span class="text-danger">*</span></label>
                        <input type="number" name="available_rooms" class="form-control" value="{{ old('available_rooms', '25') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Room Types (comma separated)</label>
                        <input type="text" name="room_types" class="form-control" value="{{ old('room_types', 'Deluxe Room, Executive Suite, Presidential Suite') }}" placeholder="Deluxe Room, Suite, Single Room">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Listing Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Visible to users)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Front Desk Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" placeholder="+92-51-1234567">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}" placeholder="reservations@hotel.com">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Image URL (Unsplash or direct image link)</label>
                        <input type="text" name="image" class="form-control" value="{{ old('image', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=80') }}" placeholder="https://...">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Description & Overview</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the hotel amenities, ambience, and nearby attractions...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-plus me-1"></i> Create Hotel Listing
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
