@extends('layouts.layout')

@section('content')
<div class="container">
    <!-- Search Form -->
    <div class="bg-white p-4 rounded-3 shadow-sm mb-4 mt-4 border border-light-subtle">
        <h4 class="mb-4">Search Flights</h4>
        <form action="{{ route('flights.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="departure_airport" class="form-label">From</label>
                    <select class="form-select" id="departure_airport" name="departure_airport" required>
                        <option value="" selected disabled>Select departure airport</option>
                        @foreach(App\Models\Airport::all() as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="arrival_airport" class="form-label">To</label>
                    <select class="form-select" id="arrival_airport" name="arrival_airport" required>
                        <option value="" selected disabled>Select arrival airport</option>
                        @foreach(App\Models\Airport::all() as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->city }} ({{ $airport->iata_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Search Flights
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Featured Flights -->
    <h4 class="mb-4">Featured Flights</h4>
    <div class="row">
        <div class="col-lg-9">
            @foreach($flights as $flight)
                <div class="bg-white p-4 rounded-3 shadow-sm mb-4 border border-light-subtle">
                    <!-- Top Section -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                        <!-- Airline Details -->
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $flight->airline->logo) }}" alt="{{ $flight->airline->name }}" style="height: 40px" />
                            <div>
                                <h5 class="fw-bold mb-1">{{ $flight->airline->name }}</h5>
                                <p class="text-muted mb-0">
                                    <select class="form-select form-select-sm class-selector" id="class-selector-{{ $flight->id }}">
                                        @foreach($flight->flightClasses as $flightClass)
                                            <option value="{{ $flightClass->id }}" data-price="{{ $flightClass->price }}">
                                                {{ $flightClass->class_type }} Class
                                            </option>
                                        @endforeach
                                    </select>
                                </p>
                                <p class="text-muted mb-0">{{ $flight->flight_number }}</p>
                            </div>
                        </div>

                        <!-- Price and Button -->
                        <div class="text-md-end">
                            <p class="text-success fw-bold fs-4 mb-2" id="price-display-{{ $flight->id }}">
                                Rp {{ number_format($flight->flightClasses->first()->price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-medium">
                                Choose Flight <i class="bi bi-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                   <!-- Flight Timeline & Facilities -->
                    <div class="row g-4">
                        <!-- Timeline -->
                        <div class="col-lg-8 flight-timeline-wrapper">
                            <div class="border-top border-bottom py-4">
                                <!-- Departure -->
                                @php
                                    $departureSegment = $flight->flightSegments->where('sequence', 1)->first();
                                @endphp
                                @if($departureSegment)
                                    <div class="d-flex align-items-start mb-4">
                                        <div class="text-center me-4" style="min-width: 80px">
                                            <p class="fw-bold text-primary mb-1">{{ $departureSegment->time->format('H:i') }}</p>
                                            <p class="text-muted small mb-0">{{ $departureSegment->time->format('d M Y') }}</p>
                                        </div>
                                        <div class="timeline-badge me-3">
                                            <span class="badge bg-warning text-dark rounded-circle p-2">
                                                <i class="bi bi-airplane-engines"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Departure</h6>
                                            <p class="mb-0 text-muted">
                                                {{ $departureSegment->airport->name }} ({{ $departureSegment->airport->iata_code }})
                                            </p>
                                            <p class="small text-muted mb-0">{{ $departureSegment->airport->city }}, {{ $departureSegment->airport->country }}</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Transit -->
                                @php
                                    $transitSegments = $flight->flightSegments
                                        ->where('sequence', '>', 1)
                                        ->where('sequence', '<', $flight->flightSegments->max('sequence'))
                                        ->sortBy('sequence');
                                @endphp
                                @foreach($transitSegments as $transitSegment)
                                    @php
                                        $nextSegment = $flight->flightSegments->where('sequence', $transitSegment->sequence + 1)->first();
                                        $transitDuration = $nextSegment ? $nextSegment->time->diffInMinutes($transitSegment->time) : 0;
                                        $transitHours = floor($transitDuration / 60);
                                        $transitMinutes = $transitDuration % 60;
                                    @endphp
                                    <div class="d-flex align-items-start mb-4">
                                        <div class="text-center me-4" style="min-width: 80px">
                                            <p class="fw-bold text-muted mb-1">{{ $transitSegment->time->format('H:i') }}</p>
                                            <p class="text-muted small mb-0">{{ $transitSegment->time->format('d M Y') }}</p>
                                        </div>
                                        <div class="timeline-badge me-3">
                                            <span class="badge bg-secondary rounded-circle p-2">
                                                <i class="bi bi-geo-alt"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Transit ({{ $transitHours }}h {{ $transitMinutes }}m)</h6>
                                            <p class="mb-0 text-muted">
                                                {{ $transitSegment->airport->name }} ({{ $transitSegment->airport->iata_code }})
                                            </p>
                                            <p class="small text-muted mb-0">{{ $transitSegment->airport->city }}, {{ $transitSegment->airport->country }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Arrival -->
                                @php
                                    $arrivalSegment = $flight->flightSegments->sortByDesc('sequence')->first();
                                @endphp
                                @if($arrivalSegment)
                                    <div class="d-flex align-items-start">
                                        <div class="text-center me-4" style="min-width: 80px">
                                            <p class="fw-bold text-success mb-1">{{ $arrivalSegment->time->format('H:i') }}</p>
                                            <p class="text-muted small mb-0">{{ $arrivalSegment->time->format('d M Y') }}</p>
                                        </div>
                                        <div class="timeline-badge me-3">
                                            <span class="badge bg-success rounded-circle p-2">
                                                <i class="bi bi-airplane-fill"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Arrival</h6>
                                            <p class="mb-0 text-muted">
                                                {{ $arrivalSegment->airport->name }} ({{ $arrivalSegment->airport->iata_code }})
                                            </p>
                                            <p class="small text-muted mb-0">{{ $arrivalSegment->airport->city }}, {{ $arrivalSegment->airport->country }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 facilities-column">
                            <h6 class="fw-bold mb-3">Flight Facilities</h6>
                            <div class="d-flex flex-column" id="facilities-{{ $flight->id }}">
                                @foreach($flight->flightClasses->first()->facilities ?? [] as $facility)
                                    <div class="facility-item">
                                        <i class="bi {{ $facility->icon_class ?? 'bi-check-circle' }} text-primary"></i>
                                        <span class="small">{{ $facility->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

            </div>
            @endforeach
        </div>

        <!-- Filters Sidebar -->
        <div class="col-lg-3">
            <form action="{{ route('flights.search') }}" method="GET" id="filter-form">
                <input type="hidden" name="departure_airport" value="{{ $request->departure_airport }}">
                <input type="hidden" name="arrival_airport" value="{{ $request->arrival_airport }}">
                <input type="hidden" name="date" value="{{ $request->date }}">
                <input type="hidden" name="passengers" value="{{ $request->passengers }}">

                <div class="bg-white p-4 rounded-3 shadow-sm" style="top: 20px">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">Filters</h5>
                        <button type="button" class="btn btn-link text-decoration-none p-0" onclick="resetFilters()">
                            Reset All
                        </button>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Price Range</h6>
                        <div class="range-slider">
                            <input type="range" class="form-range" min="0" max="5000000" step="100000"
                                   value="{{ $request->max_price ?? 5000000 }}" id="priceRange" name="max_price" />
                            <div class="d-flex justify-content-between">
                                <span class="small text-muted">Rp 0</span>
                                <span class="small text-muted" id="priceRangeValue">
                                    Rp {{ number_format($request->max_price ?? 5000000, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Type Filters -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Flight Type</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="directFlight" name="flight_type[]" value="direct"
                                {{ is_array($request->flight_type) && in_array('direct', $request->flight_type) ? 'checked' : '' }}>
                            <label class="form-check-label d-flex justify-content-between align-items-center" for="directFlight">
                                Direct Flight
                                <span class="badge bg-light text-dark">{{ $flights->filter(function($f) { return $f->flightSegments->count() == 2; })->count() }}</span>
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="transit1x" name="flight_type[]" value="1_stop"
                                {{ is_array($request->flight_type) && in_array('1_stop', $request->flight_type) ? 'checked' : '' }}>
                            <label class="form-check-label d-flex justify-content-between align-items-center" for="transit1x">
                                1 Stop
                                <span class="badge bg-light text-dark">{{ $flights->filter(function($f) { return $f->flightSegments->count() == 3; })->count() }}</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="transit2x" name="flight_type[]" value="2plus_stops"
                                {{ is_array($request->flight_type) && in_array('2plus_stops', $request->flight_type) ? 'checked' : '' }}>
                            <label class="form-check-label d-flex justify-content-between align-items-center" for="transit2x">
                                2+ Stops
                                <span class="badge bg-light text-dark">{{ $flights->filter(function($f) { return $f->flightSegments->count() >= 4; })->count() }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Airlines Filters -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Airlines</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Search airlines..." id="airlineSearch">
                        </div>
                        <div class="airlines-list" style="max-height: 200px; overflow-y: auto">
                            @foreach($airlines as $airline)
                                <div class="form-check mb-3 airline-item">
                                    <input class="form-check-input" type="checkbox" id="airline-{{ $airline->id }}" name="airlines[]" value="{{ $airline->id }}"
                                        {{ is_array($request->airlines) && in_array($airline->id, $request->airlines) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center justify-content-between" for="airline-{{ $airline->id }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}" class="me-2" style="height: 24px" />
                                            <span class="airline-name">{{ $airline->name }}</span>
                                        </div>
                                        <span class="badge bg-light text-dark">{{ $flights->where('airline_id', $airline->id)->count() }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Facilities Filters -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Facilities</h6>
                        @foreach($facilities as $facility)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="facility-{{ $facility->id }}" name="facilities[]" value="{{ $facility->id }}"
                                    {{ is_array($request->facilities) && in_array($facility->id, $request->facilities) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center justify-content-between" for="facility-{{ $facility->id }}">
                                    <span><i class="bi {{ $facility->icon_class ?? 'bi-check-circle' }} me-2"></i>{{ $facility->name }}</span>
                                    <span class="badge bg-light text-dark">
                                        {{ $flights->filter(function($f) use ($facility) {
                                            return $f->facilities->contains('id', $facility->id);
                                        })->count() }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Apply Filters Button -->
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/flights/index.js') }}"></script>
    <script src="{{ asset('js/flights/search.js') }}"></script>
@endpush
