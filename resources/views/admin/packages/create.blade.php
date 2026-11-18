@extends('layouts.admin')

@section('title', 'Create Package')
@section('page_title', 'New Vacation Tour Package')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Vacation Package Configuration</h5>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Package List
                </a>
            </div>

            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Package Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Hunza & Attabad Lake Alpine Escape">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Destination <span class="text-danger">*</span></label>
                        <input type="text" name="destination" class="form-control" value="{{ old('destination') }}" required placeholder="e.g. Hunza Valley">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', 'Pakistan') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Duration Days <span class="text-danger">*</span></label>
                        <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', '5') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Duration Nights <span class="text-danger">*</span></label>
                        <input type="number" name="duration_nights" class="form-control" value="{{ old('duration_nights', '4') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Price per Person (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', '65000') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Discount Percentage (%)</label>
                        <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent', '0') }}" min="0" max="90">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Max Capacity <span class="text-danger">*</span></label>
                        <input type="number" name="max_capacity" class="form-control" value="{{ old('max_capacity', '25') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Available Slots <span class="text-danger">*</span></label>
                        <input type="number" name="available_slots" class="form-control" value="{{ old('available_slots', '25') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Link Partner Hotel</label>
                        <select name="hotel_id" class="form-select">
                            <option value="">-- None / Standalone --</option>
                            @foreach($hotels as $h)
                                <option value="{{ $h->id }}" {{ old('hotel_id') == $h->id ? 'selected' : '' }}>{{ $h->name }} ({{ $h->city }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Link Scheduled Flight</label>
                        <select name="flight_id" class="form-select">
                            <option value="">-- None / Transport Only --</option>
                            @foreach($flights as $f)
                                <option value="{{ $f->id }}" {{ old('flight_id') == $f->id ? 'selected' : '' }}>{{ $f->airline }} ({{ $f->flight_number }}: {{ $f->origin_city }} &rarr; {{ $f->destination_city }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Cover Photo Image URL</label>
                        <input type="text" name="image" class="form-control" value="{{ old('image', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1000&q=80') }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Description & Tour Highlights <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required placeholder="Overview of the vacation package...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Daily Itinerary (One line per day)</label>
                        <textarea name="itinerary" class="form-control" rows="4" placeholder="Day 1: Departure from Islamabad, arrival and check-in.&#10;Day 2: Full day excursion and sightseeing.&#10;Day 3: Return journey.">{{ old('itinerary') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Inclusions (One item per line)</label>
                        <textarea name="inclusions" class="form-control" rows="3" placeholder="Luxury Transport&#10;Daily Breakfast&#10;Tour Guide">{{ old('inclusions') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Exclusions (One item per line)</label>
                        <textarea name="exclusions" class="form-control" rows="3" placeholder="Personal shopping&#10;Laundry">{{ old('exclusions') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="is_featured">Mark as Featured on Homepage</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Package Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active (Visible)</option>
                            <option value="inactive">Inactive (Draft)</option>
                        </select>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa-solid fa-plus me-1"></i> Save Vacation Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
