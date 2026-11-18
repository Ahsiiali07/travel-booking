@extends('layouts.admin')

@section('title', 'Edit User: ' . $user->name)
@section('page_title', 'Update User Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Edit User Profile: {{ $user->name }}</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Account Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Customer)</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Staff)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Account Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="blocked" {{ $user->status === 'blocked' ? 'selected' : '' }}>Blocked / Suspended</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+92-300-1234567">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Residential / Postal Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Reset Password (leave empty to keep current password)</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password (optional)">
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update User Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
