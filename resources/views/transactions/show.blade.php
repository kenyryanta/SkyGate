@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/transactions/show.css') }}">
@endpush


@section('title', 'Transaction Details')

@section('content')
<div class="container py-5">
    <div class="page-header">
        <span class="header-accent"></span>
        <h1 class="page-title">Transaction Details</h1>
        <p class="page-subtitle">Your booking information and flight details</p>
    </div>

    <!-- Transaction Summary -->
    <div class="premium-card mb-4">
        <div class="card-header-premium">
            <div class="header-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3>Transaction Summary</h3>
        </div>
        <div class="card-body-premium">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Transaction Code</span>
                    <span class="info-value code">{{ $transaction->code }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $transaction->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $transaction->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $transaction->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Number of Passengers</span>
                    <span class="info-value">{{ $transaction->number_of_passengers }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Status</span>
                    <div class="status-badge {{ $transaction->payment_status === 'paid' ? 'status-success' : 'status-warning' }}">
                        <i class="fas {{ $transaction->payment_status === 'paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                        <span>{{ ucfirst($transaction->payment_status) }}</span>
                    </div>
                </div>
                @if($transaction->promoCode)
                <div class="promo-item">
                    <div class="promo-label">Promo Applied</div>
                    <div class="promo-content">
                        <div class="promo-code">{{ $transaction->promoCode->code }}</div>
                        {{-- <div class="promo-discount">
                            <span>{{ $transaction->promoCode->discount }}% discount</span>
                            <i class="fas fa-tag"></i>
                        </div> --}}
                        <div class="promo-discount">
                            @if($transaction->promoCode->discount_type == 'percentage')
                                <span>{{ rtrim(rtrim(number_format($transaction->promoCode->discount, 2, '.', ''), '0'), '.') }}% discount</span>
                            @else
                                <span>Rp {{ number_format($transaction->promoCode->discount, 0, ',', '.') }} discount</span>
                            @endif
                            <i class="fas fa-tag"></i>
                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flight Details -->
    <div class="premium-card mb-4">
        <div class="card-header-premium">
            <div class="header-icon">
                <i class="fa-solid fa-plane"></i>
            </div>
            <h3>Flight Details</h3>
        </div>
        <div class="card-body-premium">
            <!-- Airline Info -->
            <div class="airline-container">
                <div class="airline-logo">
                    <img src="{{ asset('storage/' . $transaction->flight->airline->logo) }}" alt="{{ $transaction->flight->airline->name }}">
                </div>
                <div class="airline-info">
                    <h4>{{ $transaction->flight->airline->name }}</h4>
                    <p>
                        <i class="fa-solid fa-plane-departure"></i>
                        <span>Flight #{{ $transaction->flight->flight_number }}</span>
                    </p>
                </div>
            </div>

            <!-- Flight Image -->
            @if($transaction->flight->image)
            <div class="flight-image-container">
                <img src="{{ asset('storage/' . $transaction->flight->image) }}" alt="Flight Image" class="flight-image">
                <div class="image-overlay"></div>
            </div>
            @endif

            <!-- Flight Route -->
            <div class="route-section">
                <h4 class="section-title">
                    <i class="fas fa-route"></i>
                    <span>Flight Route</span>
                </h4>

                <div class="route-map">
                    @php
                        $segments = $transaction->flight->flightSegments->sortBy('sequence');
                        $count = $segments->count();
                    @endphp

                    <div class="route-line">
                        <div class="route-plane">
                            <i class="fa-solid fa-plane"></i>
                        </div>
                    </div>

                    @foreach($segments as $index => $segment)
                        <div class="route-stop" style="left: {{ ($index / ($count - 1)) * 100 }}%">
                            <div class="stop-dot {{ $loop->first ? 'dot-departure' : ($loop->last ? 'dot-arrival' : 'dot-transit') }}"></div>
                            <div class="stop-label {{ ($index % 2 == 0) ? 'label-top' : 'label-bottom' }}">
                                <div class="stop-city">{{ $segment->airport->iata_code }}</div>
                                <div class="stop-time">{{ \Carbon\Carbon::parse($segment->time)->format('H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="route-timeline">
                    @foreach($segments as $segment)
                    <div class="route-point {{ $loop->first ? 'departure' : ($loop->last ? 'arrival' : 'transit') }}">
                        <div class="point-marker">
                            <i class="fa-solid {{ $loop->first ? 'fa-plane-departure' : ($loop->last ? 'fa-plane-arrival' : 'fa-exchange-alt') }}"></i>
                        </div>
                        <div class="point-details">
                            <div class="airport">
                                <span class="airport-code">{{ $segment->airport->iata_code }}</span>
                                <span class="airport-name">{{ $segment->airport->name }}</span>
                            </div>
                            <div class="location">
                                <i class="fa-solid fa-map-marker-alt"></i>
                                <span>{{ $segment->airport->city }}, {{ $segment->airport->country }}</span>
                            </div>
                            <div class="time">
                                <i class="far fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($segment->time)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Flight Class -->
            <div class="class-section">
                <h4 class="section-title">
                    <i class="fas fa-star"></i>
                    <span>Class & Amenities</span>
                </h4>

                <div class="class-badge">
                    <i class="fa-solid {{ $transaction->flightClass->class_type === 'economy' ? 'fa-chair' :
                        ($transaction->flightClass->class_type === 'business' ? 'fa-briefcase' : 'fa-crown') }}"></i>
                    <span>{{ ucfirst($transaction->flightClass->class_type) }} Class</span>
                </div>

                <!-- Facilities -->
                @if($transaction->flightClass && $transaction->flightClass->facilities)
                <div class="facilities-grid">
                    @foreach($transaction->flightClass->facilities as $facility)
                    <div class="facility-item">
                        <div class="facility-content">
                            @if($facility->image)
                            <div class="facility-image">
                                <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}">
                            </div>
                            @endif
                            <div class="facility-details">
                                <h5>{{ $facility->name }}</h5>
                                <p>{{ $facility->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Passenger Details -->
    <div class="premium-card mb-4">
        <div class="card-header-premium">
            <div class="header-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3>Passenger Details</h3>
        </div>
        <div class="card-body-premium">
            <div class="passengers-grid">
                @foreach($transaction->passengers as $passenger)
                <div class="passenger-card">
                    <div class="passenger-avatar">
                        {{ strtoupper(substr($passenger->name, 0, 1)) }}
                    </div>
                    <div class="passenger-details">
                        <h4>{{ $passenger->name }}</h4>
                        <div class="passenger-info">
                            <div class="info-row">
                                <div class="info-col">
                                    <span class="info-label">
                                        <i class="fas fa-birthday-cake"></i> Date of Birth
                                    </span>
                                    <span class="info-value">{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d M Y') }}</span>
                                </div>
                                <div class="info-col">
                                    <span class="info-label">
                                        <i class="fas fa-flag"></i> Nationality
                                    </span>
                                    <span class="info-value">{{ $passenger->nationality }}</span>
                                </div>
                            </div>

                            @if($passenger && $passenger?->seat)
                            <div class="seat-info">
                                <span class="seat-label">
                                    <i class="fas fa-chair"></i> Seat
                                </span>
                                <span class="seat-number">{{ $passenger?->seat?->row }}{{ $passenger?->seat?->column }}</span>
                                <span class="seat-class">{{ ucfirst($passenger?->seat?->class_type) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="payment-summary">
        <div class="summary-content">
            <h3>Total Payment</h3>
            <div class="amount">Rp {{ number_format($transaction?->grandtotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-decoration">
            <div class="deco-circle deco-1"></div>
            <div class="deco-circle deco-2"></div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('home') }}" class="btn-action btn-primary">
            <i class="fa-solid fa-home"></i>
            <span>Back to Home</span>
        </a>
    </div>
</div>
@endsection
