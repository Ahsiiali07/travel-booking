@extends('layouts.admin')

@section('title', 'Reservation #' . $reservation->booking_reference)
@section('page_title', 'Reservation Inspection')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Reservations
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-pen-to-square me-1"></i> Update Status
        </a>
        <a href="{{ route('user.invoice', $reservation->id) }}" target="_blank" class="btn btn-sm btn-outline-dark">
            <i class="fa-solid fa-file-invoice me-1"></i> View Invoice
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main Reservation Details -->
    <div class="col-lg-8">
        <div class="card-admin p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
                <div>
                    <span class="badge badge-soft-{{ $reservation->type === 'flight' ? 'primary' : ($reservation->type === 'hotel' ? 'warning' : 'success') }} text-uppercase mb-1">
                        {{ $reservation->type }} Reservation
                    </span>
                    <h3 class="fw-bold text-dark mb-1">{{ $reservation->item_name }}</h3>
                    <div class="text-muted small">Registered Customer Account: <strong>{{ $reservation->user?->name ?: 'N/A' }}</strong> ({{ $reservation->user?->email }})</div>
                </div>
                <div class="text-end">
                    <span class="badge {{ $reservation->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2 text-uppercase">
                        {{ $reservation->status }}
                    </span>
                    <div class="font-monospace text-primary fw-bold mt-1">{{ $reservation->booking_reference }}</div>
                </div>
            </div>

            <!-- Schedule Dates Info -->
            <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                <div class="col-sm-4">
                    <span class="small text-muted d-block">Scheduled Travel / Check-in</span>
                    <strong class="text-dark">{{ $reservation->check_in_date ? $reservation->check_in_date->format('d M, Y') : ($reservation->travel_date?->format('d M, Y') ?: 'N/A') }}</strong>
                </div>
                <div class="col-sm-4">
                    <span class="small text-muted d-block">Check-out / Completion</span>
                    <strong class="text-dark">{{ $reservation->check_out_date ? $reservation->check_out_date->format('d M, Y') : 'N/A' }}</strong>
                </div>
                <div class="col-sm-4">
                    <span class="small text-muted d-block">Guests / Seats</span>
                    <strong class="text-dark">{{ $reservation->guests_count }} Persons ({{ $reservation->room_type ?: ($reservation->seat_class ?: 'Standard') }})</strong>
                </div>
            </div>

            <!-- Passenger Manifest -->
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-users text-primary me-2"></i> Passenger / Guest Information</h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-sm small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>CNIC / Passport</th>
                            <th>Assigned Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($reservation->passenger_details))
                            @foreach($reservation->passenger_details as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $p['name'] ?? 'N/A' }}</td>
                                    <td>{{ $p['cnic'] ?? 'N/A' }}</td>
                                    <td>{{ $p['seat'] ?? 'Assigned' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>1</td>
                                <td class="fw-bold">{{ $reservation->contact_name }}</td>
                                <td>N/A</td>
                                <td>Primary Booker</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Notes -->
            <div class="p-3 border rounded-3 bg-light small mb-3">
                <div class="fw-bold text-muted mb-1">Customer Special Requests:</div>
                <div>{{ $reservation->special_requests ?: 'No special instructions recorded.' }}</div>
            </div>
        </div>
    </div>

    <!-- Payment & Status Sidebar -->
    <div class="col-lg-4">
        <div class="card-admin p-4 mb-4">
            <h6 class="fw-bold text-dark mb-3">Financial Breakdown</h6>
            <div class="d-flex justify-content-between small text-muted mb-2">
                <span>Subtotal:</span>
                <span>PKR {{ number_format($reservation->subtotal) }}</span>
            </div>
            <div class="d-flex justify-content-between small text-muted mb-2">
                <span>Tax:</span>
                <span>+ PKR {{ number_format($reservation->tax_amount) }}</span>
            </div>
            @if($reservation->discount_amount > 0)
                <div class="d-flex justify-content-between small text-success mb-2">
                    <span>Discount:</span>
                    <span>- PKR {{ number_format($reservation->discount_amount) }}</span>
                </div>
            @endif
            <div class="d-flex justify-content-between fw-bold text-dark fs-5 pt-2 border-top mb-3">
                <span>Total Amount:</span>
                <span class="text-primary">PKR {{ number_format($reservation->total_amount) }}</span>
            </div>

            <div class="p-3 bg-light rounded-3 small">
                <div class="d-flex justify-content-between mb-1">
                    <span>Payment Status:</span>
                    <span class="badge {{ $reservation->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} text-uppercase">
                        {{ $reservation->payment_status }}
                    </span>
                </div>
                @if($reservation->payment)
                    <div class="d-flex justify-content-between mb-1">
                        <span>Transaction:</span>
                        <span class="font-monospace">{{ $reservation->payment->transaction_id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Method:</span>
                        <span>{{ ucwords(str_replace('_', ' ', $reservation->payment->payment_method)) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Paid At:</span>
                        <span>{{ $reservation->payment->paid_at?->format('d M, Y h:i A') }}</span>
                    </div>
                @endif
            </div>

            @if($reservation->refund)
                <div class="alert alert-danger small mt-3 mb-0">
                    <div class="fw-bold"><i class="fa-solid fa-rotate-left me-1"></i> Refund Associated:</div>
                    Ref: <strong>{{ $reservation->refund->refund_reference }}</strong> ({{ ucfirst($reservation->refund->status) }})<br>
                    <a href="{{ route('admin.refunds.show', $reservation->refund->id) }}" class="text-danger fw-bold">View Refund Details &rarr;</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
