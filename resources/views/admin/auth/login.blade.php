@extends('layouts.app')

@section('title', 'Administrator Portal Login')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card border-0 shadow-xl overflow-hidden" style="border-radius: 28px; box-shadow: 0 25px 60px -15px rgba(16, 45, 69, 0.15), 0 10px 25px -5px rgba(0, 0, 0, 0.05);">
                <div class="row g-0">
                    <!-- Left Column: Admin Brand Panel -->
                    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative" style="background: linear-gradient(180deg, rgba(7, 25, 43, 0.85) 0%, rgba(16, 45, 69, 0.95) 100%), url('https://images.unsplash.com/photo-1769939830039-3291f2721e8c?auto=format&fit=crop&w=900&q=85') center/cover no-repeat; min-height: 540px;">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-4" style="background: rgba(255, 107, 74, 0.2); border: 1px solid rgba(255, 107, 74, 0.4); font-size: 0.72rem; letter-spacing: 0.12em; font-weight: 700; text-transform: uppercase; color: #ff8b73;">
                                <i class="fa-solid fa-shield-halved"></i>
                                SECURE ADMIN CONTROL
                            </div>
                            <h2 class="fw-bold display-6 mb-3" style="font-family: 'Manrope', sans-serif; letter-spacing: -0.03em; line-height: 1.15;">
                                Central Administration Panel
                            </h2>
                            <p class="text-light opacity-80 small leading-relaxed">
                                Complete CRUD operations for flights, partner hotels, and vacation packages, alongside real-time reservation control and refund processing.
                            </p>
                        </div>

                        <div>
                            <div class="p-3 rounded-4 mb-3" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12);">
                                <div class="small text-light opacity-90 fw-semibold mb-1"><i class="fa-solid fa-graduation-cap text-warning me-1"></i> Virtual University CS619 Final Project</div>
                                <div class="small text-light opacity-70">Supervisor: Sheikh Israr Ahmad (israr.ahmad@vu.edu.pk)</div>
                            </div>
                            <div class="small text-light opacity-60">
                                Laravel 12 &bull; MySQL &bull; Role-Based Access Control
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Admin Form -->
                    <div class="col-lg-7 p-4 p-sm-5 bg-white d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="brand-icon-wrapper" style="width: 38px; height: 38px; font-size: 1rem; border-radius: 12px; background: #102d45;">
                                    <i class="fa-solid fa-lock text-white"></i>
                                </div>
                                <span class="fw-bold fs-5 text-dark" style="font-family: 'Manrope', sans-serif;">TravelBooking</span>
                                <span class="badge ms-auto" style="background: #fff0ec; color: #e54e2e; font-size: 0.72rem;">ADMIN PORTAL</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1" style="font-family: 'Manrope', sans-serif;">Administrator Sign In</h3>
                            <p class="text-muted small">Enter your authorized administrative credentials to continue</p>
                        </div>

                        <!-- Quick Demo Credentials for Viva -->
                        <div class="p-3 mb-4 rounded-4 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: #fff0ec; border: 1px solid #ffd5cc;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="background: #e54e2e; color: #ffffff; font-size: 0.72rem;">Admin Demo</span>
                                <code class="text-dark fw-bold small">admin@travelbooking.com</code>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1" style="border-radius: 9999px; border-color: #ff6b4a; color: #e54e2e; font-size: 0.8rem; font-weight: 600; padding: 0.3rem 0.85rem;" onclick="fillAdminDemo()">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Auto Fill
                            </button>
                        </div>

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold small text-muted mb-1">Administrator Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 48px;" value="{{ old('email') }}" required autofocus placeholder="admin@travelbooking.com">
                                </div>
                                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-bold small text-muted mb-0">Admin Password</label>
                                    <a href="{{ route('admin.password.request') }}" class="small text-decoration-none fw-semibold" style="color: #ff6b4a;">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 14px 0 0 14px; border-color: #cbd5e1;"><i class="fa-solid fa-lock text-muted"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" style="border-radius: 0 14px 14px 0; border-color: #cbd5e1; height: 48px;" required placeholder="Enter admin password">
                                </div>
                                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Keep admin session active</label>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3 fw-bold" style="background: #102d45; border-color: #102d45; border-radius: 9999px; font-size: 1rem;">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Access Admin Dashboard
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top small text-muted">
                            Need to register a new admin? 
                            <a href="{{ route('admin.register') }}" class="fw-bold text-decoration-none" style="color: #ff6b4a;">Admin Registration</a>
                            <div class="mt-2">
                                <a href="{{ route('login') }}" class="text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Switch to User Portal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillAdminDemo() {
    document.getElementById('email').value = 'admin@travelbooking.com';
    document.getElementById('password').value = 'password123';
}
</script>
@endsection