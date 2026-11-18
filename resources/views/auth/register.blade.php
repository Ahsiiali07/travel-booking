@extends('layouts.app')

@section('title', 'User Registration')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-3 mb-2">
                            <i class="fa-solid fa-user-plus fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Create User Account</h3>
                        <p class="text-muted small">Register to book flights, hotels, and customized holiday packages</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                                    <input type="text" name="name" id="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Ali Ahmed Khan">
                                </div>
                                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                                </div>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold small">Mobile / Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                    <input type="text" name="phone" id="phone" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+92-300-1234567">
                                </div>
                                @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label fw-semibold small">City</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-city text-muted"></i></span>
                                    <input type="text" name="city" id="city" class="form-control border-start-0 ps-0 @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="e.g. Lahore, Islamabad">
                                </div>
                                @error('city')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label fw-semibold small">Street Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-location-dot text-muted"></i></span>
                                    <input type="text" name="address" id="address" class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Street, Sector / Block">
                                </div>
                                @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required placeholder="Minimum 6 characters">
                                </div>
                                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-shield-halved text-muted"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 ps-0" required placeholder="Repeat password">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary-custom w-100 py-2">
                                <i class="fa-solid fa-user-check me-1"></i> Complete Registration
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary">Log In here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
