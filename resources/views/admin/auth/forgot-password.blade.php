@extends('layouts.app')

@section('title', 'Admin Password Recovery')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex p-3 mb-2">
                        <i class="fa-solid fa-unlock-keyhole fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Admin Password Reset</h4>
                    <p class="text-light opacity-75 small mb-0">Recover administrator access</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if(session('status'))
                        <div class="alert alert-success small mb-3">
                            <i class="fa-solid fa-check-circle me-1"></i> {{ session('status') }}
                        </div>
                        @if(session('demo_reset_url'))
                            <div class="alert alert-info small mb-4">
                                <div class="fw-bold mb-1"><i class="fa-solid fa-flask me-1"></i> Testing Admin Reset Link:</div>
                                <a href="{{ session('demo_reset_url') }}" class="btn btn-sm btn-dark mt-1 w-100">
                                    Click to Reset Admin Password
                                </a>
                            </div>
                        @endif
                    @endif

                    <form action="{{ route('admin.password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small">Admin Account Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', 'admin@travelbooking.com') }}" required placeholder="admin@travelbooking.com">
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                            <i class="fa-solid fa-paper-plane me-1"></i> Send Password Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top small">
                        <a href="{{ route('admin.login') }}" class="fw-bold text-decoration-none text-dark"><i class="fa-solid fa-arrow-left me-1"></i> Back to Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
