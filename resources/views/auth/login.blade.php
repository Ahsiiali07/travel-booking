@extends('layouts.app')

@section('title', 'User Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex p-3 mb-2">
                            <i class="fa-solid fa-user fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Welcome Back</h3>
                        <p class="text-muted small">Log in to manage your flight, hotel & vacation schedules</p>
                    </div>

                    <!-- Quick Demo Credentials Fill for Testing / Viva -->
                    <div class="alert alert-light border small d-flex justify-content-between align-items-center mb-4 rounded-3">
                        <div>
                            <span class="badge bg-secondary me-1">Demo User</span>
                            <code>user@travelbooking.com</code>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="fillUserDemo()">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Auto Fill
                        </button>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-semibold small mb-0">Password</label>
                                <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">Forgot Password?</a>
                            </div>
                            <div class="input-group mt-1">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required placeholder="Enter password">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label small" for="remember">Remember me on this browser</label>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-2">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Log In
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Don't have an account yet? <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-primary">Create User Account</a>
                        <div class="mt-2 text-muted">
                            Are you an administrator? <a href="{{ route('admin.login') }}" class="text-secondary fw-semibold">Admin Login</a>
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
