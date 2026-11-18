@extends('layouts.app')

@section('title', 'Create User Account')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="card border-0 shadow-xl overflow-hidden" style="border-radius: 28px; box-shadow: 0 25px 60px -15px rgba(16, 45, 69, 0.15), 0 10px 25px -5px rgba(0, 0, 0, 0.05);">
                <div class="row g-0">
                    <!-- Left Column: Luxury Travel Branding (Desktop) -->
                    <div class="col-lg-4 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative" style="background: linear-gradient(180deg, rgba(7, 25, 43, 0.45) 0%, rgba(7, 25, 43, 0.90) 100%), url('https://images.unsplash.com/photo-1779831859141-452040bc1463?auto=format&fit=crop&w=900&q=85') center/cover no-repeat; min-height: 620px;">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-4" style="background: rgba(255, 255, 255, 0.14); border: 1px solid rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); font-size: 0.72rem; letter-spacing: 0.12em; font-weight: 700; text-transform: uppercase;">
                                <span style="width: 7px; height: 7px; border-radius: 50%; background: #ffb64d; display: inline-block;"></span>
                                JOIN TRAVELBOOKING
                            </div>
                            <h2 class="fw-bold fs-2 mb-3" style="font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; line-height: 1.2;">
                                Start your next great story.
                            </h2>
                            <p class="text-light opacity-80 small leading-relaxed">
                                Join thousands of travelers planning bespoke journeys, reserving premium rooms, and securing airline seats across Pakistan.
                            </p>
                        </div>

                        <div>
                            <div class="d-flex flex-column gap-2 mb-4">
                                <div class="d-flex align-items-center gap-2 small text-light opacity-90">
                                    <i class="fa-solid fa-circle-check text-success"></i> Instant flight ticket scheduling
                                </div>
                                <div class="d-flex align-items-center gap-2 small text-light opacity-90">
                                    <i class="fa-solid fa-circle-check text-success"></i> Verified hotel stay vouchers
                                </div>
                                <div class="d-flex align-items-center gap-2 small text-light opacity-90">
                                    <i class="fa-solid fa-circle-check text-success"></i> Transparent payments & refunds
                                </div>
                            </div>
                            <div class="pt-3 border-top border-white border-opacity-10 small text-light opacity-70">
                                Virtual University CS619 FYP &bull; Laravel 12 &bull; MySQL
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Registration Form -->
                    <div class="col-lg-8 p-4 p-sm-5 bg-white">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="brand-icon-wrapper" style="width: 38px; height: 38px; font-size: 1rem; border-radius: 12px; background: #ff6b4a;">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </div>
                                <span class="fw-bold fs-5 text-dark" style="font-family: 'Manrope', sans-serif;">TravelBooking</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Manrope', sans-serif;">Create User Account</h3>
                            <p class="text-muted small">Register to book flights, hotels, and customized holiday packages</p>
                        </div>

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label fw-bold small text-muted mb-1">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-user text-muted"></i></span>
                                        <input type="text" name="name" id="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" value="{{ old('name') }}" required placeholder="e.g. Ali Ahmed Khan">
                                    </div>
                                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold small text-muted mb-1">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-envelope text-muted"></i></span>
                                        <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" value="{{ old('email') }}" required placeholder="name@example.com">
                                    </div>
                                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-bold small text-muted mb-1">Mobile / Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-phone text-muted"></i></span>
                                        <input type="text" name="phone" id="phone" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" value="{{ old('phone') }}" placeholder="+92-300-1234567">
                                    </div>
                                    @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="city" class="form-label fw-bold small text-muted mb-1">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-city text-muted"></i></span>
                                        <input type="text" name="city" id="city" class="form-control border-start-0 ps-0 @error('city') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" value="{{ old('city') }}" placeholder="e.g. Lahore, Islamabad">
                                    </div>
                                    @error('city')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-bold small text-muted mb-1">Street Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-location-dot text-muted"></i></span>
                                        <input type="text" name="address" id="address" class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" value="{{ old('address') }}" placeholder="Sector / Area">
                                    </div>
                                    @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold small text-muted mb-1">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-lock text-muted"></i></span>
                                        <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" required placeholder="Min 6 characters">
                                    </div>
                                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold small text-muted mb-1">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-shield-halved text-muted"></i></span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 ps-0" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 46px;" required placeholder="Repeat password">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold" style="font-size: 1rem;">
                                    <i class="fa-solid fa-user-check me-1"></i> Complete Registration
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top small text-muted">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #ff6b4a;">Log In here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection