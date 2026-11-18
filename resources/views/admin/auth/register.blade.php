@extends('layouts.app')

@section('title', 'Administrator Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex p-3 mb-2">
                        <i class="fa-solid fa-user-shield fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Admin Account Registration</h4>
                    <p class="text-light opacity-75 small mb-0">Authorized Staff Registration Portal &bull; CS619</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-info small mb-4">
                        <i class="fa-solid fa-info-circle me-1"></i> Admin registration requires the <strong>System Security Key</strong>. The default demo key is: <code>VU-CS619-ADMIN</code>.
                    </div>

                    <form action="{{ route('admin.register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small">Administrator Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. System Administrator">
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Admin Work Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="admin.new@travelbooking.com">
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold small">Contact Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+92-300-1122334">
                            @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_secret" class="form-label fw-semibold small">Admin Security Authorization Key <span class="text-danger">*</span></label>
                            <input type="text" name="admin_secret" id="admin_secret" class="form-control font-monospace @error('admin_secret') is-invalid @enderror" value="VU-CS619-ADMIN" required>
                            @error('admin_secret')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min 6 characters">
                                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repeat password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                            <i class="fa-solid fa-user-check me-1"></i> Register as Administrator
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Already have admin credentials? <a href="{{ route('admin.login') }}" class="fw-bold text-decoration-none text-dark">Log In here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
