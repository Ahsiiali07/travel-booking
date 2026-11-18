@extends('layouts.admin')

@section('title', 'Process Refund: ' . $refund->refund_reference)
@section('page_title', 'Review & Process Refund')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Process Refund #{{ $refund->refund_reference }}</h5>
                    <div class="small text-muted">Customer: <strong>{{ $refund->user?->name }}</strong> &bull; Booking: {{ $refund->reservation?->booking_reference }}</div>
                </div>
                <a href="{{ route('admin.refunds.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Refunds
                </a>
            </div>

            <!-- Claim Reason Banner -->
            <div class="p-3 bg-light rounded-3 mb-4">
                <div class="small fw-bold text-muted text-uppercase mb-1">Customer Claim Reason:</div>
                <div class="text-dark small">{{ $refund->reason }}</div>
            </div>

            <form action="{{ route('admin.refunds.update', $refund->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Refund Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $refund->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $refund->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="processed" {{ $refund->status === 'processed' ? 'selected' : '' }}>Processed (Reverses payment & cancels booking)</option>
                            <option value="rejected" {{ $refund->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Refund Amount (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $refund->amount) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Refund Method <span class="text-danger">*</span></label>
                        <input type="text" name="refund_method" class="form-control" value="{{ old('refund_method', $refund->refund_method) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Admin Remarks / Reason for Decision</label>
                        <textarea name="admin_remarks" class="form-control" rows="3" placeholder="Enter remarks visible to customer / internal audit notes...">{{ old('admin_remarks', $refund->admin_remarks) }}</textarea>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Update Refund Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
