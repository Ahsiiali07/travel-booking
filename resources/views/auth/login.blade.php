@extends('layouts.app')

@section('title', 'User Login')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card border-0 shadow-xl overflow-hidden" style="border-radius: 28px; box-shadow: 0 25px 60px -15px rgba(16, 45, 69, 0.15), 0 10px 25px -5px rgba(0, 0, 0, 0.05);">
                <div class="row g-0">
                    <!-- Left Column: Luxury Scenic Travel Showcase (Desktop) -->
                    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative" style="background: linear-gradient(180deg, rgba(7, 25, 43, 0.45) 0%, rgba(7, 25, 43, 0.88) 100%), url('https://images.unsplash.com/photo-1774681972371-d87f13a3996c?auto=format&fit=crop&w=1200&q=88') center/cover no-repeat; min-height: 560px;">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-4" style="background: rgba(255, 255, 255, 0.14); border: 1px solid rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); font-size: 0.72rem; letter-spacing: 0.12em; font-weight: 700; text-transform: uppercase;">
                                <span style="width: 7px; height: 7px; border-radius: 50%; background: #ffb64d; display: inline-block;"></span>
                                CURATED JOURNEYS
                            </div>
                            <h2 class="fw-bold display-6 mb-3" style="font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; line-height: 1.15;">
                                Go where you feel most alive.
                            </h2>
                            <p class="text-light opacity-80 small leading-relaxed">
                                Log in to access your flight tickets, luxury hotel reservations, and custom vacation schedules all in one unified place.
                            </p>
                        </div>

                        <div>
                            <div class="p-3 rounded-4 mb-3" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.18); backdrop-filter: blur(8px);">
                                <div class="d-flex align-items-center gap-2 text-warning mb-1 small">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <span class="text-white fw-bold ms-1">4.9 / 5</span>
                                </div>
                                <div class="small text-light opacity-90 fst-italic">"Seamless flight scheduling and hotel bookings across Pakistan!"</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between text-light opacity-70 small">
                                <span>Virtual University CS619</span>
                                <span>Supervisor: Sheikh Israr Ahmad</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Clean Modern Form -->
                    <div class="col-lg-7 p-4 p-sm-5 bg-white d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="brand-icon-wrapper" style="width: 38px; height: 38px; font-size: 1rem; border-radius: 12px; background: #ff6b4a;">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </div>
                                <span class="fw-bold fs-5 text-dark" style="font-family: 'Manrope', sans-serif;">TravelBooking</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Manrope', sans-serif;">Welcome Back</h3>
                            <p class="text-muted small">Sign in to manage your flight tickets, hotel stays & bookings</p>
                        </div>

                        <!-- Quick Demo Credentials Pill Bar -->
                        <div class="p-3 mb-4 rounded-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: #fff0ec; border: 1px solid #ffd5cc;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background: #e54e2e; color: #ffffff; font-size: 0.72rem;">Demo User</span>
                                <code class="text-dark fw-bold small">user@travelbooking.com</code>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" style="border-radius: 9999px; border-color: #ff6b4a; color: #e54e2e; font-size: 0.8rem; font-weight: 600; padding: 0.3rem 0.85rem;" onclick="fillUserDemo()">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Auto Fill
                            </button>
                        </div>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold small text-muted mb-1">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 48px;" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-bold small text-muted mb-0">Password</label>
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none fw-semibold" style="color: #ff6b4a;">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 48px;" required placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Remember me</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold" style="font-size: 1rem;">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Sign In to Account
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top small text-muted">
                            Don't have an account yet? 
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #ff6b4a;">Create User Account</a>
                            <div class="mt-2 text-muted" style="font-size: 0.8rem;">
                                Are you an administrator? 
                                <a href="{{ route('admin.login') }}" class="text-secondary fw-semibold">Admin Login &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillUserDemo() {
    document.getElementById('email').value = 'user@travelbooking.com';
    document.getElementById('password').value = 'password123';
}
</script>
@endsection