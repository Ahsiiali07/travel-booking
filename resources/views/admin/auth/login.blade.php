@extends('layouts.app')

@section('title', 'Administrator Portal Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-3 mb-2">
                        <i class="fa-solid fa-shield-halved fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-1">TravelBooking Admin</h4>
                    <p class="text-light opacity-75 small mb-0">Management Portal &bull; VU CS619 FYP</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Quick Demo Credentials for Viva -->
                    <div class="alert alert-warning border small d-flex justify-content-between align-items-center mb-4 rounded-3">
                        <div>
                            <span class="badge bg-dark me-1">Admin Demo</span>
                            <code>admin@travelbooking.com</code>
                        </div>
                        <button type="button" class="btn btn-sm btn-dark" onclick="fillAdminDemo()">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto Fill
                        </button>
                    </div>

                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Administrator Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="admin@travelbooking.com">
                            </div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-semibold small mb-0">Admin Password</label>
                                <a href="{{ route('admin.password.request') }}" class="small text-decoration-none text-danger">Forgot Password?</a>
                            </div>
                            <div class="input-group mt-1">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required placeholder="Enter admin password">
                            </div>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Keep admin session active</label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Access Admin Dashboard
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Need to register a new admin? <a href="{{ route('admin.register') }}" class="fw-bold text-decoration-none text-dark">Admin Registration</a>
                        <div class="mt-2">
                            <a href="{{ route('login') }}" class="text-muted"><i class="fa-solid fa-arrow-left me-1"></i> Switch to User Login</a>
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
