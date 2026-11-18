@extends('layouts.app')

@section('title', 'My Account Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h3 class="fw-bold text-dark mb-4"><i class="fa-solid fa-user-gear text-primary me-2"></i> Account Settings</h3>

            <!-- Profile Info Form -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3">Personal Information</h5>
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email Address (Read-only)</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Contact Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+92-300-1234567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Residential Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" placeholder="Full postal address">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary-custom"><i class="fa-solid fa-floppy-disk me-1"></i> Save Profile Details</button>
                    </div>
                </form>
            </div>

            <!-- Password Update Form -->
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark mb-3">Update Security Password</h5>
                <form action="{{ route('user.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required placeholder="Enter existing password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimum 6 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn-detail-figma py-2 px-3"><i class="fa-solid fa-lock me-1"></i> Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
