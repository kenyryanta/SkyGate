@extends('layouts.layout')

@section('title', 'Payment Details')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/transactions/payment.css') }}">
@endpush

@section('content')
<div class="container py-5 payment-container">
    <div class="row justify-content-center g-4">
        <!-- Main Payment Card -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Payment Header with Gradient -->
                <div class="card-header bg-primary-gradient text-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold">Payment Details</h4>
                        <p class="mb-0 opacity-75">Transaction #{{ $transaction->code }}</p>
                    </div>
                    <div>
                        <span class="status-badge badge
                            {{ $transaction->payment_status === 'paid' ? 'bg-success-soft text-success' :
                              ($transaction->payment_status === 'pending' ? 'bg-warning-soft text-warning' : 'bg-danger-soft text-danger') }}">
                            <i class="bi {{ $transaction->payment_status === 'paid' ? 'bi-check-circle-fill' :
                                        ($transaction->payment_status === 'pending' ? 'bi-clock-fill' : 'bi-x-circle-fill') }} me-1"></i>
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Transaction Information -->
                    <div class="transaction-info mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary-soft text-primary me-3">
                                <i class="bi bi-airplane"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Flight Details</h5>
                        </div>

                        <div class="flight-info-card p-3 rounded-3 bg-light mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="airline-logo-container me-3">
                                            <!-- Airline logo can be added here -->
                                            <i class="bi bi-airplane-engines fs-4 text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Airline</small>
                                            <p class="mb-0 fw-semibold">{{ $transaction->flight->airline->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box me-3 text-info">
                                            <i class="bi bi-hash"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Flight Number</small>
                                            <p class="mb-0 fw-semibold">{{ $transaction->flight->flight_number }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box me-3 text-success">
                                            <i class="bi bi-ticket-perforated"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Class</small>
                                            <p class="mb-0 fw-semibold">{{ ucfirst($transaction->flightClass->class_type) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box me-3 text-warning">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Passengers</small>
                                            <p class="mb-0 fw-semibold">{{ $transaction->number_of_passengers }} person(s)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Cards -->
                    @if($transaction->payment_status === 'paid')
                        <div class="status-card success-card p-4 rounded-3 mb-4">
                            <div class="d-flex">
                                <div class="status-icon me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-success mb-1">Payment Successful</h5>
                                    <p class="mb-0">Your payment has been completed successfully. Your e-ticket has been sent to your email.</p>
                                    <a href="#" class="btn btn-sm btn-outline-success mt-2">
                                        <i class="bi bi-envelope me-1"></i> View E-Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif($transaction->payment_status === 'pending')
                        <div class="status-card warning-card p-4 rounded-3 mb-4">
                            <div class="d-flex">
                                <div class="status-icon me-3">
                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-warning mb-1">Payment Pending</h5>
                                    <p class="mb-0">Your payment is still pending. Please complete the payment to receive your e-ticket.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="status-card danger-card p-4 rounded-3 mb-4">
                            <div class="d-flex">
                                <div class="status-icon me-3">
                                    <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-danger mb-1">Payment Failed</h5>
                                    <p class="mb-0">Your payment has failed. Please try again or contact our support team for assistance.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Button -->
                    @if($transaction->payment_status === 'pending')
                    <div class="payment-button-container text-center py-3">
                        <button id="pay-button" class="btn btn-lg btn-primary px-5 py-3 animate-pulse">
                            <i class="bi bi-credit-card-fill me-2"></i>Proceed to Payment
                        </button>
                        <div class="secure-badge mt-3">
                            <i class="bi bi-shield-lock-fill text-success me-1"></i>
                            <small class="text-muted">Secure Payment</small>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="support-info">
                            <i class="bi bi-headset me-2 text-primary"></i>
                            <span>Need help? Contact our <a href="mailto:support@airline.com" class="text-decoration-none">support team</a></span>
                        </div>
                        <div class="payment-methods mt-2 mt-md-0">
                            <i class="bi bi-credit-card me-1 text-muted"></i>
                            <i class="bi bi-paypal me-1 text-muted"></i>
                            <i class="bi bi-wallet2 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="col-lg-4">
            <div class="card shadow border-0 rounded-4 sticky-offset">
                <div class="card-header bg-light p-4 border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        Payment Summary
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Transaction ID -->
                    <div class="transaction-id-container p-3 bg-light rounded-3 mb-4 text-center">
                        <small class="text-muted d-block mb-1">Transaction ID</small>
                        <span class="transaction-id fw-bold text-primary">{{ $transaction->code }}</span>
                    </div>

                    <!-- Class and Price -->
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="text-muted">Class</span>
                        <span class="fw-semibold">{{ ucfirst($transaction->flightClass->class_type) }}</span>
                    </div>

                    <!-- Price per Passenger -->
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="text-muted">Price per Passenger</span>
                        <span class="fw-semibold">Rp {{ number_format($transaction->flightClass->price, 0, ',', '.') }}</span>
                    </div>

                    <!-- Total Passengers -->
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Passengers</span>
                        <span class="fw-semibold">{{ $transaction->number_of_passengers }} x Rp {{ number_format($transaction->flightClass->price, 0, ',', '.') }}</span>
                    </div>

                    <!-- Subtotal -->
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <!-- Discount (if applicable) -->
                    @if($transaction->promoCode)
                    <div class="summary-item d-flex justify-content-between mb-3 text-success">
                        <span>
                            <i class="bi bi-tag-fill me-1"></i>
                            Discount ({{ $transaction->promoCode->discount_type === 'percentage' ? $transaction->promoCode->discount . '%' : 'Flat' }})
                        </span>
                        @php
                            $discount = $transaction->subtotal - $transaction->grandtotal;
                        @endphp
                        <span class="fw-bold">-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <!-- Grand Total -->
                    <div class="total-container p-3 bg-light rounded-3 mt-4">
                        <div class="d-flex justify-content-between fw-bold">
                            <span class="fs-5">Total</span>
                            <span class="fs-5 text-primary">Rp {{ number_format($transaction->grandtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-4 border-0">
                    <div class="payment-status text-center">
                        @if($transaction->payment_status === 'paid')
                            <div class="badge bg-success-soft text-success p-2 w-100">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Payment Completed
                            </div>
                        @elseif($transaction->payment_status === 'pending')
                            <div class="badge bg-warning-soft text-warning p-2 w-100">
                                <i class="bi bi-clock-fill me-1"></i>
                                Payment Pending
                            </div>
                        @else
                            <div class="badge bg-danger-soft text-danger p-2 w-100">
                                <i class="bi bi-x-circle-fill me-1"></i>
                                Payment Failed
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById("pay-button").onclick = function () {
    snap.pay("{{ $snapToken }}", {
        onSuccess: function (result) {
            alert("Payment successful! Updating status...");

            // Panggil Webhook secara manual
            fetch('{{ route("transactions.notification") }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({
                    order_id: "{{ $transaction->code }}",
                    transaction_status: "settlement",
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Webhook response:", data);
                    if (data.status === "success") {
                        alert("Payment updated! Redirecting...");
                        window.location.href =
                            '{{ route("transactions.show", $transaction->id) }}';
                    } else {
                        alert("Failed to update payment status.");
                    }
                })
                .catch((error) => {
                    console.error("Error calling webhook:", error);
                    alert("Error updating payment status.");
                });
        },

        onPending: function (result) {
            alert("Payment is pending. Please complete your payment.");
            console.log(result);
        },

        onError: function (result) {
            alert("Payment failed. Please try again.");
            console.log(result);
        },

        onClose: function () {
            alert(
                "You closed the payment window without completing the payment."
            );
        },
    });
};
</script>
@endsection
