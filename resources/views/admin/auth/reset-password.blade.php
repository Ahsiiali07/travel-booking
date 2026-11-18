@extends('layouts.app')

@section('title', 'Admin Set New Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-custom border-0 shadow-lg">
                <div class="card-header bg-dark text-white text-center py-4 border-0">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex p-3 mb-2">
                        <i class="fa-solid fa-lock-open fs-3"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Set New Admin Password</h4>
                    <p class="text-light opacity-75 small mb-0">Update admin security credentials</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small">Admin Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small">New Admin Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimum 6 characters">
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small">Confirm New Admin Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirm new password">
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                            <i class="fa-solid fa-check-double me-1"></i> Update Admin Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
