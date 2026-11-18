@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex p-3 mb-2">
                            <i class="fa-solid fa-key fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Reset Password</h3>
                        <p class="text-muted small">Enter your registered email to receive a password reset token</p>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success small mb-3">
                            <i class="fa-solid fa-check-circle me-1"></i> {{ session('status') }}
                        </div>
                        @if(session('demo_reset_url'))
                            <div class="alert alert-info small mb-4">
                                <div class="fw-bold mb-1"><i class="fa-solid fa-flask me-1"></i> Testing Reset Link (Local Mail Mode):</div>
                                <a href="{{ session('demo_reset_url') }}" class="btn btn-sm btn-info text-white mt-1 w-100">
                                    Click Here to Complete Password Reset
                                </a>
                            </div>
                        @endif
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small">Registered Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="e.g. user@travelbooking.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-2">
                            <i class="fa-solid fa-paper-plane me-1"></i> Generate Password Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        Remembered your password? <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
