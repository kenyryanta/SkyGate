@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/transactions/index.css') }}">
@endpush

@section('title', 'Transaction')

@section('content')
<div class="container py-5">
    <div class="section-header text-center mb-5">
        <h2 class="fw-bold display-6 text-gradient">
            <i class="fas fa-receipt me-2"></i> Booking List
        </h2>
        <div class="header-line mx-auto mt-3"></div>
    </div>

    @if($transactions->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h3 class="empty-state-title">No transactions yet</h3>
            <p class="empty-state-description">Your booked flight tickets will appear here</p>
            <a href="{{ route('flights.index') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3 btn-hover-effect">
                <i class="fas fa-search me-2"></i> Search Flights
            </a>
        </div>
    @else
        <div class="row justify-content-center">
            @foreach($transactions->sortByDesc('created_at') as $transaction)
                <div class="col-lg-10 mb-4">
                    <div class="ticket-card">
                        <div class="ticket-card-header">
                            <div class="airline-info">
                                @if($transaction->flight->airline->logo)
                                    <div class="airline-logo-container">
                                        <img src="{{ asset('storage/' . $transaction->flight->airline->logo) }}"
                                             alt="{{ $transaction->flight->airline->name }}"
                                             class="airline-logo">
                                    </div>
                                @else
                                    <div class="airline-logo-placeholder">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                @endif
                                <div class="airline-details">
                                    <h5 class="airline-name">{{ $transaction->flight->airline->name }}</h5>
                                    <span class="flight-number">{{ $transaction->flight->flight_number }}</span>
                                </div>
                            </div>
                            <div class="booking-status">
                                <div class="status-indicator
                                    {{ $transaction->payment_status == 'paid' ? 'status-success' :
                                    ($transaction->payment_status == 'unpaid' ? 'status-warning' : 'status-danger') }}">
                                    <i class="fas fa-{{ $transaction->payment_status == 'paid' ? 'check-circle' :
                                        ($transaction->payment_status == 'unpaid' ? 'clock' : 'times-circle') }}"></i>
                                    <span>{{ ucfirst($transaction->payment_status) }}</span>
                                </div>

                                @if($transaction->payment_status == 'paid' || $transaction->payment_status == 'unpaid')
                                    <small class="status-message">
                                        {{ $transaction->payment_status == 'paid' ? 'Payment successful.' : 'Awaiting payment.' }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="ticket-divider">
                            <div class="divider-circle left"></div>
                            <div class="divider-line"></div>
                            <div class="divider-circle right"></div>
                        </div>

                        <!-- Flight Details -->
                        @php
                            $flightSegments = $transaction->flight->flightSegments->sortBy('sequence');
                            $firstSegment = $flightSegments->first();
                            $lastSegment = $flightSegments->last();
                            $transitSegments = $flightSegments->slice(1, -1);
                        @endphp

                        <div class="flight-itinerary">
                            <div class="flight-timeline">
                                <!-- Departure -->
                                <div class="timeline-point departure">
                                    <div class="timeline-icon">
                                         <i class="fa-solid fa-plane-departure"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="airport-code">{{ $firstSegment->airport->iata_code }}</div>
                                        <div class="airport-name">{{ $firstSegment->airport->name }}</div>
                                        <div class="timeline-time">{{ \Carbon\Carbon::parse($firstSegment->time)->format('d M Y') }}</div>
                                        <div class="timeline-time-hour">{{ \Carbon\Carbon::parse($firstSegment->time)->format('H:i') }}</div>
                                    </div>
                                </div>

                                <!-- Flight Path -->
                                <div class="flight-path">
                                    <div class="path-line">
                                        <div class="plane-icon">
                                            <i class="fas fa-plane"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arrival -->
                                <div class="timeline-point arrival">
                                    <div class="timeline-icon">
                                        <i class="fa-solid fa-plane-arrival"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="airport-code">{{ $lastSegment->airport->iata_code }}</div>
                                        <div class="airport-name">{{ $lastSegment->airport->name }}</div>
                                        <div class="timeline-time">{{ \Carbon\Carbon::parse($lastSegment->time)->format('d M Y') }}</div>
                                        <div class="timeline-time-hour">{{ \Carbon\Carbon::parse($lastSegment->time)->format('H:i') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transit Information Section -->
                            @if($transitSegments->count() > 0)
                                <div class="transit-section mt-4">
                                    <h6 class="transit-section-title">
                                        <i class="fas fa-exchange-alt me-2"></i> Transit Information
                                    </h6>
                                    <div class="transit-timeline">
                                        @foreach($transitSegments as $index => $segment)
                                            @php
                                                // Calculate transit duration if not last transit
                                                $transitDuration = null;
                                                if($index < $transitSegments->count() - 1) {
                                                    $currentTime = \Carbon\Carbon::parse($segment->time);
                                                    $nextTime = \Carbon\Carbon::parse($transitSegments[$index + 1]->time);
                                                    $transitDuration = $currentTime->diff($nextTime);
                                                } elseif($transitSegments->count() == 1) {
                                                    $departureTime = \Carbon\Carbon::parse($firstSegment->time);
                                                    $arrivalTime = \Carbon\Carbon::parse($lastSegment->time);
                                                    $transitDuration = $departureTime->diff($arrivalTime);
                                                }
                                            @endphp
                                            <div class="transit-item">
                                                <div class="transit-indicator">
                                                    <div class="transit-number">{{ $index + 1 }}</div>
                                                </div>
                                                <div class="transit-details">
                                                    <div class="transit-airport">
                                                        <i class="fas fa-map-marker-alt me-2"></i>
                                                        <span>{{ $segment->airport->name }} ({{ $segment->airport->iata_code }})</span>
                                                    </div>
                                                    <div class="transit-time">
                                                        <i class="far fa-clock me-2"></i>
                                                        <span>{{ \Carbon\Carbon::parse($segment->time)->format('d M Y, H:i') }}</span>
                                                    </div>
                                                    @if($transitDuration)
                                                        <div class="transit-duration">
                                                            <i class="fas fa-hourglass-half me-2"></i>
                                                            <span>Transit Duration:
                                                                @if($transitDuration->h > 0)
                                                                    {{ $transitDuration->h }} hour(s)
                                                                @endif
                                                                @if($transitDuration->i > 0)
                                                                    {{ $transitDuration->i }} minute(s)
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ticket-divider">
                            <div class="divider-circle left"></div>
                            <div class="divider-line"></div>
                            <div class="divider-circle right"></div>
                        </div>

                        <!-- Transaction Info -->
                        <div class="ticket-footer">
                            <div class="booking-info">
                                <div class="booking-code">
                                    <span class="info-label">Booking Code</span>
                                    <span class="info-value">{{ $transaction->code }}</span>
                                </div>
                                <div class="booking-price">
                                    <span class="info-label">Total</span>
                                    <span class="info-value">Rp {{ number_format($transaction->grandtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($transaction->payment_status == 'paid')
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-view-details">
                                    <span>View Details</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            @else
                                <a href="{{ route('transactions.payment', ['transaction' => $transaction->id]) }}" class="btn-view-details">
                                    <span>Continue Payment</span>
                                    <i class="fa-solid fa-credit-card"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
