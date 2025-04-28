@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/flights/show.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Search Results
        </a>
    </div>

    <!-- Flight Header -->
    <div class="flight-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white rounded-circle p-2 me-3">
                        <img src="{{ asset('storage/' . $flight->airline->logo) }}" alt="{{ $flight->airline->name }}" height="50">
                    </div>
                    <div>
                        <h2 class="mb-0">{{ $flight->airline->name }}</h2>
                        <p class="mb-0 opacity-75">Flight {{ $flight->flight_number }}</p>
                    </div>
                </div>

                @php
                    $departureSegment = $flight->flightSegments->where('sequence', 1)->first();
                    $arrivalSegment = $flight->flightSegments->sortByDesc('sequence')->first();

                    if ($departureSegment && $arrivalSegment) {
                        $duration = $arrivalSegment->time->diffInMinutes($departureSegment->time);
                        $hours = floor($duration / 60);
                        $minutes = $duration % 60;
                    }
                @endphp

                <div class="d-flex align-items-center">
                    <div class="text-center me-4">
                        <h3 class="mb-0">{{ $departureSegment->airport->iata_code }}</h3>
                        <p class="mb-0 opacity-75">{{ $departureSegment->airport->city }}</p>
                    </div>
                    <div class="px-4 text-center">
                        <p class="mb-0 opacity-75">{{ $hours }}h {{ $minutes }}m</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded-circle" style="width: 8px; height: 8px;"></div>
                            <div class="flight-path-animation"></div>
                            <div class="bg-white rounded-circle" style="width: 8px; height: 8px;"></div>
                        </div>
                        <p class="mb-0 opacity-75">
                            {{ $flight->flightSegments->count() - 2 > 0 ? ($flight->flightSegments->count() - 2) . ' Stop(s)' : 'Direct' }}
                        </p>
                    </div>
                    <div class="text-center ms-4">
                        <h3 class="mb-0">{{ $arrivalSegment->airport->iata_code }}</h3>
                        <p class="mb-0 opacity-75">{{ $arrivalSegment->airport->city }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <div class="bg-white bg-opacity-25 p-3 rounded-3 d-inline-block">
                    <p class="mb-1">Starting from</p>
                    <h2 class="mb-0">Rp {{ number_format($flight->flightClasses->min('price'), 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Flight Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>Flight Details</h4>
                </div>
                <div class="card-body p-4">
                    <div class="timeline-wrapper">
                        <div class="timeline-line"></div>

                        @foreach($flight->flightSegments as $segment)
                            <div class="d-flex mb-4 timeline-point">
                                @if($segment->sequence == 1)
                                    <div class="timeline-point-circle bg-primary text-white">
                                        <i class="bi bi-airplane-engines-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Departure</h5>
                                        <h4 class="mb-1">{{ $segment->time->format('H:i') }} - {{ $segment->time->format('d M Y') }}</h4>
                                        <p class="mb-0">{{ $segment->airport->name }} ({{ $segment->airport->iata_code }})</p>
                                        <p class="text-muted mb-0">{{ $segment->airport->city }}, {{ $segment->airport->country }}</p>
                                    </div>
                                @elseif($segment->sequence == $flight->flightSegments->max('sequence'))
                                    <div class="timeline-point-circle bg-success text-white">
                                        <i class="bi bi-airplane-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Arrival</h5>
                                        <h4 class="mb-1">{{ $segment->time->format('H:i') }} - {{ $segment->time->format('d M Y') }}</h4>
                                        <p class="mb-0">{{ $segment->airport->name }} ({{ $segment->airport->iata_code }})</p>
                                        <p class="text-muted mb-0">{{ $segment->airport->city }}, {{ $segment->airport->country }}</p>
                                    </div>
                                @else
                                    @php
                                        $nextSegment = $flight->flightSegments->where('sequence', $segment->sequence + 1)->first();
                                        $transitDuration = $nextSegment ? $nextSegment->time->diffInMinutes($segment->time) : 0;
                                        $transitHours = floor($transitDuration / 60);
                                        $transitMinutes = $transitDuration % 60;
                                    @endphp
                                    <div class="timeline-point-circle bg-warning text-dark">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Transit ({{ $transitHours }}h {{ $transitMinutes }}m)</h5>
                                        <h4 class="mb-1">{{ $segment->time->format('H:i') }} - {{ $segment->time->format('d M Y') }}</h4>
                                        <p class="mb-0">{{ $segment->airport->name }} ({{ $segment->airport->iata_code }})</p>
                                        <p class="text-muted mb-0">{{ $segment->airport->city }}, {{ $segment->airport->country }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Facilities -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="bi bi-stars me-2"></i>Flight Facilities</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 facility-container">
                        <!-- Fasilitas akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>

        </div>

        <!-- Booking Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i>Book Your Flight</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('flights.booking.form', $flight->id) }}" method="GET" id="bookingForm">
                        <div class="mb-3">
                            <label class="form-label">Select Class</label>
                            <div class="d-flex flex-wrap">
                                @foreach($flight->flightClasses as $index => $class)
                                    <div class="form-check me-3 mb-2">
                                        <input class="form-check-input class-radio" type="radio" name="class_type"
                                               id="class-{{ $class->id }}" value="{{ $class->class_type }}"
                                               data-price="{{ $class->price }}"
                                               data-facilities="{{ json_encode($class->facilities) }}"
                                               {{ $index == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="class-{{ $class->id }}">
                                            <div class="class-tab {{ $index == 0 ? 'active' : '' }}">
                                                <h6 class="mb-1">{{ $class->class_type }}</h6>
                                                <p class="mb-0 text-success fw-bold">Rp {{ number_format($class->price, 0, ',', '.') }}</p>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Passenger Count -->
                        <div class="mb-4">
                            <label for="passengerCount" class="form-label">Number of Passengers</label>
                            <select class="form-select" id="passengerCount" name="passengers">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Passenger' : 'Passengers' }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Available Seats -->
                        <div class="mb-4">
                            <p class="mb-2">Available Seats: <span class="fw-bold text-success" id="availableSeatsCount">{{ $flight->seats->where('is_available', true)->count() }}</span></p>
                            <div class="progress" style="height: 10px;">
                                @php
                                    $totalSeats = $flight->flightClasses->sum('total_seats');
                                    $availableSeats = $flight->seats->where('is_available', true)->count();
                                    $percentage = $totalSeats > 0 ? ($availableSeats / $totalSeats) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Promo Codes -->
                        @if($validPromos->isNotEmpty())
                            <div class="mb-4">
                                <label for="promoCode" class="form-label">Promo Code</label>
                                <select class="form-select" id="promoCode" name="promo_code_id">
                                    <option value="">Select a promo code</option>
                                    @foreach($validPromos as $promo)
                                        <option value="{{ $promo->id }}" data-discount="{{ $promo->discount }}" data-type="{{ $promo->discount_type }}">
                                            {{ $promo->code }} - {{ $promo->discount_type == 'percentage' ? $promo->discount . '%' : 'Rp ' . number_format($promo->discount, 0, ',', '.') }} off
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Price Summary -->
                        <div class="price-summary-card mb-4">
                            <h5 class="mb-3">Price Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Base Price</span>
                                <span id="basePrice">Rp {{ number_format($flight->flightClasses->first()->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Passengers</span>
                                <span id="passengerCountDisplay">1</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 promo-row" style="display: none !important;">
                                <span>Promo Discount</span>
                                <span id="promoDiscount">- Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span id="totalPrice">Rp {{ number_format($flight->flightClasses->first()->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Book Now Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 booking-btn">
                            <i class="bi bi-credit-card me-2"></i>Continue to Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/flights/show.js') }}"></script>
@endpush
