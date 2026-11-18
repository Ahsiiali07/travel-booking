@extends('layouts.admin')

@section('title', 'Issue Manual Refund')
@section('page_title', 'Create Manual Refund')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark">Issue Manual Refund Record</h5>
                <a href="{{ route('admin.refunds.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Refunds
                </a>
            </div>

            <form action="{{ route('admin.refunds.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Select Paid Reservation <span class="text-danger">*</span></label>
                        <select name="reservation_id" id="reservation_id" class="form-select" required onchange="fillAmount(this)">
                            <option value="">-- Choose Paid Reservation --</option>
                            @foreach($paidReservations as $res)
                                <option value="{{ $res->id }}" data-amount="{{ $res->total_amount }}">
                                    [{{ $res->booking_reference }}] {{ $res->item_name }} &bull; Customer: {{ $res->contact_name }} (PKR {{ number_format($res->total_amount) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Refund Amount (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="refund_amount" class="form-control" required placeholder="0.00">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Initial Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="processed">Processed (Mark Reservation Refunded)</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Refund Channel / Method <span class="text-danger">*</span></label>
                        <input type="text" name="refund_method" class="form-control" value="original_payment_method" required placeholder="e.g. original_payment_method, bank_transfer, cash">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Reason for Refund <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Detailed reason for issuing this refund..."></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Admin Remarks / Notes</label>
                        <textarea name="admin_remarks" class="form-control" rows="2" placeholder="Internal administrator notes or audit trail..."></textarea>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fa-solid fa-plus me-1"></i> Create Refund Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function fillAmount(select) {
    const selectedOption = select.options[select.selectedIndex];
    const amount = selectedOption.getAttribute('data-amount') || 0;
    document.getElementById('refund_amount').value = amount;
}
</script>
@endsection
