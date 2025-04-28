@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/flights/booking.css') }}">
@endpush

@section('title', 'Book Flight')
@section('content')
<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Flight Details
        </a>
    </div>

    <!-- Booking Progress -->
    <div class="booking-progress">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="position-relative">
                    <div class="progress position-absolute" style="width: 100%; height: 3px; top: 25px; z-index: 1;">
                        <div class="progress-bar" role="progressbar" style="width: 33%"></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="text-center position-relative">
                            <div class="progress-step-circle bg-primary text-white">
                                <i class="bi bi-1-circle-fill"></i>
                            </div>
                            <p class="mt-2 mb-0 text-primary fw-bold">Booking</p>
                        </div>

                        <div class="text-center position-relative">
                            <div class="progress-step-circle bg-light text-muted">
                                <i class="bi bi-2-circle"></i>
                            </div>
                            <p class="mt-2 mb-0 text-muted">Payment</p>
                        </div>

                        <div class="text-center position-relative">
                            <div class="progress-step-circle bg-light text-muted">
                                <i class="bi bi-3-circle"></i>
                            </div>
                            <p class="mt-2 mb-0 text-muted">Confirmation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Booking Form -->
        <div class="col-lg-8">
            <form action="{{ route('flights.booking.process', $flight->id) }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="flight_class_id" value="{{ $selectedClass->id }}">

                <!-- Contact Information -->
                <div class="card passenger-form">
                    <div class="card-body p-4">
                        <h4 class="mb-4"><i class="bi bi-person-vcard me-2"></i>Contact Information</h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full Name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Tabs -->
                <div class="d-flex mb-3 passenger-tabs">
                    @for($i = 1; $i <= request()->passengers; $i++)
                        <div class="passenger-tab {{ $i == 1 ? 'active' : '' }}" data-passenger="{{ $i }}">
                            Passenger {{ $i }}
                        </div>
                    @endfor
                </div>

                <!-- Passenger Forms -->
                @for($i = 1; $i <= request()->passengers; $i++)
                    <div class="passenger-panel card passenger-form {{ $i > 1 ? 'd-none' : '' }}" id="passenger-panel-{{ $i }}">
                        <div class="card-body p-4">
                            <h4 class="mb-4"><i class="bi bi-person me-2"></i>Passenger {{ $i }} Details</h4>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control @error('passengers.' . ($i - 1) . '.name') is-invalid @enderror"
                                            id="passenger{{ $i }}_name"
                                            name="passengers[{{ $i - 1 }}][name]"
                                            placeholder="Full Name"
                                            value="{{ old('passengers.' . ($i - 1) . '.name') }}"
                                            required>
                                        <label for="passenger{{ $i }}_name">Full Name</label>
                                        @error('passengers.' . ($i - 1) . '.name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="date"
                                            class="form-control @error('passengers.' . ($i - 1) . '.date_of_birth') is-invalid @enderror"
                                            id="passenger{{ $i }}_dob"
                                            name="passengers[{{ $i - 1 }}][date_of_birth]"
                                            placeholder="Date of Birth"
                                            value="{{ old('passengers.' . ($i - 1) . '.date_of_birth') }}"
                                            required>
                                        <label for="passenger{{ $i }}_dob">Date of Birth</label>
                                        @error('passengers.' . ($i - 1) . '.date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control @error('passengers.' . ($i - 1) . '.nationality') is-invalid @enderror"
                                            id="passenger{{ $i }}_nationality"
                                            name="passengers[{{ $i - 1 }}][nationality]"
                                            placeholder="Nationality"
                                            value="{{ old('passengers.' . ($i - 1) . '.nationality') }}"
                                            required>
                                        <label for="passenger{{ $i }}_nationality">Nationality</label>
                                        @error('passengers.' . ($i - 1) . '.nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control @error('passengers.' . ($i - 1) . '.passport_number') is-invalid @enderror"
                                            id="passenger{{ $i }}_passport"
                                            name="passengers[{{ $i - 1 }}][passport_number]"
                                            placeholder="Passport Number"
                                            value="{{ old('passengers.' . ($i - 1) . '.passport_number') }}">
                                        <label for="passenger{{ $i }}_passport">Passport Number (Optional)</label>
                                        @error('passengers.' . ($i - 1) . '.passport_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <input type="hidden" id="passenger{{ $i }}_seat_id" name="passengers[{{ $i-1 }}][seat_id]" value="{{ old('passengers.' . ($i - 1) . '.seat_id') }}">
                                    <div class="seat-map-container">
                                        <div class="seat-map-header">
                                            <h5 class="mb-3">Select a Seat for Passenger {{ $i }}</h5>
                                            <div class="d-flex justify-content-center flex-wrap">
                                                <div class="seat-legend me-3 mb-2">
                                                    <div class="seat-legend-box bg-secondary"></div>
                                                    <span>Unavailable</span>
                                                </div>
                                                <div class="seat-legend me-3 mb-2">
                                                    <div class="seat-legend-box" style="background-color: #e9ecef;"></div>
                                                    <span>Available</span>
                                                </div>
                                                <div class="seat-legend mb-2">
                                                    <div class="seat-legend-box bg-primary"></div>
                                                    <span>Selected</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="seat-map" id="seat-map-{{ $i }}" style="display: grid; grid-template-columns: auto auto auto auto auto auto; gap: 10px; align-items: center;">
                                            @foreach($flight->seats->groupBy('column') as $row => $seats)
                                                <div class="window-indicator" style="width: 10px; height: 100%; background: linear-gradient(to right, rgba(0,0,0,0.2), transparent); transform: translateX(85px);">
                                                </div>
                                                @foreach($seats as $seat)
                                                    @php
                                                        $seatNumber = $seat->row . $seat->column;
                                                        $isAvailable = (bool) $seat->is_available;
                                                        $isSelected = old('passengers.' . ($i - 1) . '.seat_id') == $seat->id;
                                                        $seatClass = $isSelected
                                                            ? 'selected'
                                                            : ($isAvailable ? 'available' : 'unavailable');
                                                    @endphp

                                                    <div class="seat {{ $seatClass }}"
                                                         data-seat-id="{{ $seat->id }}"
                                                         data-seat-number="{{ $seatNumber }}"
                                                         style="background-color: {{ $isSelected ? '#0d6efd' : ($isAvailable ? '#e9edef' : '#343a40') }};">
                                                        {{ $seatNumber }}
                                                    </div>
                                                @endforeach
                                                <div class="window-indicator ms-2" style="width: 10px; height: 100%; background: linear-gradient(to left, rgba(0,0,0,0.2), transparent);"></div>
                                            @endforeach
                                        </div>

                                        <div class="seat-map-footer">
                                            <p class="mb-0">Selected Seat: <span id="selected-seat-display-{{ $i }}">
                                                {{ old('passengers.' . ($i - 1) . '.seat_id') ?
                                                    ($flight->seats->where('id', old('passengers.' . ($i - 1) . '.seat_id'))->first() ?
                                                        $flight->seats->where('id', old('passengers.' . ($i - 1) . '.seat_id'))->first()->row .
                                                        chr(64 + $flight->seats->where('id', old('passengers.' . ($i - 1) . '.seat_id'))->first()->column) :
                                                        'None') :
                                                    'None' }}
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" class="btn btn-outline-secondary" id="prevPassenger" disabled>
                        <i class="bi bi-arrow-left me-2"></i>Previous Passenger
                    </button>

                    <button type="button" class="btn btn-outline-primary" id="nextPassenger" {{ request()->passengers > 1 ? '' : 'disabled' }}>
                        Next Passenger<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

                            <!-- Promo Code Section -->
                <div class="card passenger-form mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4"><i class="bi bi-tag me-2"></i>Promo Code</h4>
                        <div class="input-group">
                            <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Enter promo code (if any)" value="{{ old('promo_code') }}">
                            <button class="btn btn-outline-secondary" type="button" id="applyPromoCode">Apply</button>
                        </div>
                        <!-- Hidden field for promo code ID -->
                        <input type="hidden" id="promo_code_id" name="promo_code_id" value="{{ old('promo_code_id') }}">
                        <div id="promoCodeMessage" class="mt-2"></div>
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-credit-card me-2"></i>Continue to Payment
                    </button>
                </div>
            </form>
        </div>

        <!-- Flight Summary -->
        <div class="col-lg-4">
            <div class="card" style="top: 20px">
                <div class="card-body p-0">
                    <!-- Flight Summary Header -->
                    <div class="flight-summary p-4 mb-4">
                        <h4 class="mb-3">Flight Summary</h4>
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $flight->airline->logo) }}" alt="{{ $flight->airline->name }}" class="me-3" style="height: 40px;">
                            <div>
                                <h5 class="mb-0">{{ $flight->airline->name }}</h5>
                                <p class="mb-0">{{ $flight->flight_number }}</p>
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

                        <div class="d-flex justify-content-between mt-3">
                            <div class="text-center">
                                <h5 class="mb-0">{{ $departureSegment->time->format('H:i') }}</h5>
                                <p class="mb-0 small">{{ $departureSegment->time->format('d M Y') }}</p>
                                <p class="mb-0">{{ $departureSegment->airport->iata_code }}</p>
                            </div>

                            <div class="d-flex flex-column align-items-center justify-content-center px-3">
                                <p class="mb-0 small">{{ $hours }}h {{ $minutes }}m</p>
                                <div class="d-flex align-items-center">
                                    <div class="bg-white rounded-circle" style="width: 6px; height: 6px;"></div>
                                    <div class="bg-white" style="height: 2px; width: 50px;"></div>
                                    <i class="bi bi-airplane-fill text-white small"></i>
                                    <div class="bg-white" style="height: 2px; width: 50px;"></div>
                                    <div class="bg-white rounded-circle" style="width: 6px; height: 6px;"></div>
                                </div>
                                <p class="mb-0 small">
                                    {{ $flight->flightSegments->count() - 2 > 0 ? ($flight->flightSegments->count() - 2) . ' Stop(s)' : 'Direct' }}
                                </p>
                            </div>

                            <div class="text-center">
                                <h5 class="mb-0">{{ $arrivalSegment->time->format('H:i') }}</h5>
                                <p class="mb-0 small">{{ $arrivalSegment->time->format('d M Y') }}</p>
                                <p class="mb-0">{{ $arrivalSegment->airport->iata_code }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="p-4">
                        <h5 class="mb-3">Booking Details</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Class</span>
                            <span class="fw-bold">{{ $selectedClass->class_type }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Passengers</span>
                            <span class="fw-bold">{{ request()->passengers }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per person</span>
                            <span>Rp {{ number_format($selectedClass->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total passengers</span>
                            <span>{{ request()->passengers }} x Rp {{ number_format($selectedClass->price, 0, ',', '.') }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2" id="discountRow" style="display: none;">
                            <span>Discount</span>
                            <span id="discountAmount">-Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-primary" id="grandTotal">Rp {{ number_format($selectedClass->price * request()->passengers, 0, ',', '.') }}</span>
                        </div>

                        <!-- Flight Facilities -->
                        <div class="mt-4">
                            <h5 class="mb-3">Facilities</h5>
                            <div class="d-flex flex-wrap">
                                @foreach($flight->facilities->where('pivot.flight_class_id', $selectedClass->id) as $facility)
                                    <div class="me-3 mb-2 d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                                        <span>{{ $facility->name }}</span>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // Handle passenger tabs
    const passengerTabs = document.querySelectorAll('.passenger-tab');
    const passengerPanels = document.querySelectorAll('.passenger-panel');
    const prevButton = document.getElementById('prevPassenger');
    const nextButton = document.getElementById('nextPassenger');
    let currentPassenger = 1;
    const totalPassengers = {{ request()->passengers }};

    function showPassengerPanel(passengerIndex) {
        // Hide all panels
        passengerPanels.forEach(panel => {
            panel.classList.add('d-none');
        });

        // Show the selected panel
        document.getElementById(`passenger-panel-${passengerIndex}`).classList.remove('d-none');

        // Update tabs
        passengerTabs.forEach(tab => {
            tab.classList.remove('active');
        });

        passengerTabs[passengerIndex - 1].classList.add('active');

        // Update navigation buttons
        prevButton.disabled = passengerIndex === 1;
        nextButton.disabled = passengerIndex === totalPassengers;

        // Update current passenger
        currentPassenger = passengerIndex;
    }

    // Add click event to tabs
    passengerTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const passengerIndex = parseInt(this.dataset.passenger);
            showPassengerPanel(passengerIndex);
        });
    });

    // Previous button click
    prevButton.addEventListener('click', function() {
        if (currentPassenger > 1) {
            showPassengerPanel(currentPassenger - 1);
        }
    });

    // Next button click
    nextButton.addEventListener('click', function() {
        if (currentPassenger < totalPassengers) {
            showPassengerPanel(currentPassenger + 1);
        }
    });

    // Handle seat selection
    const selectedSeats = new Set();

    // Initialize selected seats from old input
    @for($i = 1; $i <= request()->passengers; $i++)
        @if(old('passengers.' . ($i - 1) . '.seat_id'))
            selectedSeats.add("{{ old('passengers.' . ($i - 1) . '.seat_id') }}");
        @endif
    @endfor

    for (let i = 1; i <= totalPassengers; i++) {
        const seatMap = document.getElementById(`seat-map-${i}`);
        const seatIdInput = document.getElementById(`passenger${i}_seat_id`);
        const selectedSeatDisplay = document.getElementById(`selected-seat-display-${i}`);
        let selectedSeat = null; // Define selectedSeat variable

        if (seatMap) {
            const seats = seatMap.querySelectorAll('.seat');

            // Mark seats that are selected by other passengers as unavailable
            seats.forEach(seat => {
                const seatId = seat.dataset.seatId;

                // If this seat is selected by another passenger, mark it as unavailable
                if (selectedSeats.has(seatId) && !seat.classList.contains('selected')) {
                    seat.classList.remove('available');
                    seat.classList.add('unavailable');
                }

                seat.addEventListener('click', function() {
                    if (this.classList.contains('available')) {
                        // Get previously selected seat for this passenger
                        const prevSeatId = seatIdInput.value;

                        // If there was a previously selected seat, remove it from the set
                        if (prevSeatId) {
                            selectedSeats.delete(prevSeatId);

                            // Make the previously selected seat available in all seat maps
                            document.querySelectorAll(`.seat[data-seat-id="${prevSeatId}"]`).forEach(s => {
                                if (!s.classList.contains('selected')) {
                                    s.classList.remove('unavailable');
                                    s.classList.add('available');
                                }
                            });
                        }

                        // Deselect previously selected seat
                        if (selectedSeat) {
                            selectedSeat.classList.remove('selected');
                            selectedSeat.classList.add('available');
                        }

                        // Select new seat
                        this.classList.remove('available');
                        this.classList.add('selected');
                        selectedSeat = this;

                        // Update hidden input and display
                        seatIdInput.value = this.dataset.seatId;
                        selectedSeatDisplay.textContent = this.dataset.seatNumber;

                        // Add to selected seats set
                        selectedSeats.add(this.dataset.seatId);

                        // Mark seat as unavailable in other passenger's seat maps
                        for (let j = 1; j <= totalPassengers; j++) {
                            if (j !== i) {
                                const otherSeatMap = document.getElementById(`seat-map-${j}`);
                                if (otherSeatMap) {
                                    const otherSeats = otherSeatMap.querySelectorAll('.seat');
                                    otherSeats.forEach(otherSeat => {
                                        if (otherSeat.dataset.seatId === this.dataset.seatId) {
                                            otherSeat.classList.remove('available');
                                            otherSeat.classList.add('unavailable');
                                        }
                                    });
                                }
                            }
                        }
                    }
                });
            });
        }
    }

    // Promo code functionality
    const promoCodeInput = document.getElementById('promo_code');
    const applyPromoBtn = document.getElementById('applyPromoCode');
    const promoCodeMessage = document.getElementById('promoCodeMessage');
    const discountRow = document.getElementById('discountRow');
    const discountAmount = document.getElementById('discountAmount');
    const grandTotal = document.getElementById('grandTotal');
    const basePrice = {{ $selectedClass->price * request()->passengers }};

    // Add promo code section if it doesn't exist
    if (!promoCodeInput) {
        const promoSection = document.createElement('div');
        promoSection.className = 'card passenger-form mb-4';
        promoSection.innerHTML = `
            <div class="card-body p-4">
                <h4 class="mb-4"><i class="bi bi-tag me-2"></i>Promo Code</h4>
                <div class="input-group">
                    <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Enter promo code (if any)" value="{{ old('promo_code') }}">
                    <button class="btn btn-outline-secondary" type="button" id="applyPromoCode">Apply</button>
                </div>
                <div id="promoCodeMessage" class="mt-2"></div>
            </div>
        `;

        // Insert before submit button
        const submitButtonContainer = document.querySelector('.d-grid');
        if (submitButtonContainer) {
            submitButtonContainer.parentNode.insertBefore(promoSection, submitButtonContainer);
        }
    }

    // Add discount row if it doesn't exist
    if (!discountRow) {
        const totalRow = document.querySelector('.d-flex.justify-content-between.fw-bold');
        if (totalRow) {
            const discountRowElement = document.createElement('div');
            discountRowElement.className = 'd-flex justify-content-between mb-2';
            discountRowElement.id = 'discountRow';
            discountRowElement.style.display = 'none';
            discountRowElement.innerHTML = `
                <span>Discount</span>
                <span id="discountAmount">-Rp 0</span>
            `;

            // Insert before total row
            totalRow.parentNode.insertBefore(discountRowElement, totalRow);
        }
    }

    // Apply promo code functionality
    const applyPromoButton = document.getElementById('applyPromoCode');
    if (applyPromoButton) {
        applyPromoButton.addEventListener('click', function() {
            const promoCodeInput = document.getElementById('promo_code');
            const promoCodeMessage = document.getElementById('promoCodeMessage');
            const promoCode = promoCodeInput.value.trim();

            if (!promoCode) {
                promoCodeMessage.innerHTML = '<span class="text-danger">Please enter a promo code</span>';
                return;
            }

            // Fetch promo code data from database via API
            fetch('/api/promo-codes/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ code: promoCode })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const discountRow = document.getElementById('discountRow');
                const discountAmount = document.getElementById('discountAmount');
                const grandTotal = document.getElementById('grandTotal');

                if (data.valid) {
                    // Show success message
                    promoCodeMessage.innerHTML = `<span class="text-success">Promo code applied: ${data.description}</span>`;

                    // Calculate discount
                    let discount = 0;
                    if (data.discount_type === 'percentage') {
                        discount = (basePrice * data.discount) / 100;
                    } else {
                        discount = parseFloat(data.discount);
                    }

                    // Update UI
                    if (discountRow) discountRow.style.display = 'flex';
                    if (discountAmount) discountAmount.textContent = `-Rp ${numberFormat(discount)}`;
                    if (grandTotal) grandTotal.textContent = `Rp ${numberFormat(basePrice - discount)}`;

                    // Add hidden input for the server
                    let hiddenPromoInput = document.querySelector('input[name="applied_promo_code"]');
                    if (!hiddenPromoInput) {
                        hiddenPromoInput = document.createElement('input');
                        hiddenPromoInput.type = 'hidden';
                        hiddenPromoInput.name = 'applied_promo_code';
                        const bookingForm = document.getElementById('bookingForm');
                        if (bookingForm) bookingForm.appendChild(hiddenPromoInput);
                    }
                    if (hiddenPromoInput) hiddenPromoInput.value = promoCode;

                } else {
                    // Show error message
                    promoCodeMessage.innerHTML = `<span class="text-danger">${data.message}</span>`;

                    // Reset discount
                    if (discountRow) discountRow.style.display = 'none';
                    if (grandTotal) grandTotal.textContent = `Rp ${numberFormat(basePrice)}`;

                    // Remove hidden input if exists
                    const existingHiddenPromo = document.querySelector('input[name="applied_promo_code"]');
                    if (existingHiddenPromo) {
                        existingHiddenPromo.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                promoCodeMessage.innerHTML = '<span class="text-danger">An error occurred while validating the promo code</span>';
            });
        });
    }


    // Helper function to format numbers with thousand separators
    function numberFormat(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Form validation before submit
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            let valid = true;

            // Check if all passengers have selected seats
            for (let i = 1; i <= totalPassengers; i++) {
                const seatIdInput = document.getElementById(`passenger${i}_seat_id`);
                if (seatIdInput && !seatIdInput.value) {
                    alert(`Please select a seat for Passenger ${i}`);
                    showPassengerPanel(i);
                    valid = false;
                    break;
                }
            }

            // Validate contact information
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            if (nameInput && !nameInput.value.trim()) {
                alert('Please enter contact name');
                nameInput.focus();
                valid = false;
            } else if (emailInput && (!emailInput.value.trim() || !emailInput.value.includes('@'))) {
                alert('Please enter a valid email address');
                emailInput.focus();
                valid = false;
            } else if (phoneInput && !phoneInput.value.trim()) {
                alert('Please enter contact phone number');
                phoneInput.focus();
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    // Initialize seat maps with proper availability status
    document.addEventListener('DOMContentLoaded', function() {
        // This would typically come from your backend
        const unavailableSeats = [
            // Example of seats that are already booked
            // In a real application, this would be populated from your database
        ];

        // Mark seats as unavailable
        unavailableSeats.forEach(seatId => {
            document.querySelectorAll(`.seat[data-seat-id="${seatId}"]`).forEach(seat => {
                seat.classList.remove('available');
                seat.classList.add('unavailable');
            });
        });
    });
</script>
@endsection
