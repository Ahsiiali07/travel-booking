@extends('layouts.app')

@section('title', 'Set New Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-success-subtle text-success rounded-circle d-inline-flex p-3 mb-2">
                            <i class="fa-solid fa-lock-open fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Create New Password</h3>
                        <p class="text-muted small">Enter and confirm your new secure password</p>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Account Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimum 6 characters">
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Re-type new password">
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-2">
                            <i class="fa-solid fa-check-double me-1"></i> Update Password & Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
