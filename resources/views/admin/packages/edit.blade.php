@extends('layouts.admin')

@section('title', 'Edit Package: ' . $package->name)
@section('page_title', 'Update Vacation Package')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Edit Package: {{ $package->name }}</h5>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Package List
                </a>
            </div>

            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Package Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Destination <span class="text-danger">*</span></label>
                        <input type="text" name="destination" class="form-control" value="{{ old('destination', $package->destination) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $package->country) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Duration Days <span class="text-danger">*</span></label>
                        <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', $package->duration_days) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Duration Nights <span class="text-danger">*</span></label>
                        <input type="number" name="duration_nights" class="form-control" value="{{ old('duration_nights', $package->duration_nights) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Price per Person (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $package->price) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Discount Percentage (%)</label>
                        <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent', $package->discount_percent) }}" min="0" max="90">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Max Capacity <span class="text-danger">*</span></label>
                        <input type="number" name="max_capacity" class="form-control" value="{{ old('max_capacity', $package->max_capacity) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Available Slots <span class="text-danger">*</span></label>
                        <input type="number" name="available_slots" class="form-control" value="{{ old('available_slots', $package->available_slots) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Link Partner Hotel</label>
                        <select name="hotel_id" class="form-select">
                            <option value="">-- None / Standalone --</option>
                            @foreach($hotels as $h)
                                <option value="{{ $h->id }}" {{ $package->hotel_id == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Link Scheduled Flight</label>
                        <select name="flight_id" class="form-select">
                            <option value="">-- None / Transport Only --</option>
                            @foreach($flights as $f)
                                <option value="{{ $f->id }}" {{ $package->flight_id == $f->id ? 'selected' : '' }}>{{ $f->airline }} ({{ $f->flight_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Cover Photo Image URL</label>
                        <input type="text" name="image" class="form-control" value="{{ old('image', $package->image) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Description & Tour Highlights <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $package->description) }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Daily Itinerary (One line per day)</label>
                        @php
                            $itineraryText = '';
                            if (is_array($package->itinerary)) {
                                foreach ($package->itinerary as $day) {
                                    $itineraryText .= ($day['details'] ?? '') . "\n";
                                }
                            }
                        @endphp
                        <textarea name="itinerary" class="form-control" rows="4">{{ old('itinerary', trim($itineraryText)) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Inclusions (One item per line)</label>
                        <textarea name="inclusions" class="form-control" rows="3">{{ old('inclusions', is_array($package->inclusions) ? implode("\n", $package->inclusions) : '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Exclusions (One item per line)</label>
                        <textarea name="exclusions" class="form-control" rows="3">{{ old('exclusions', is_array($package->exclusions) ? implode("\n", $package->exclusions) : '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ $package->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="is_featured">Mark as Featured</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Package Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $package->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $package->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Package Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
