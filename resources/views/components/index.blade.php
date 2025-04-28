@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/index.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
      <section class="hero">
        <div class="container">
          <h1>Find Your Next Destination</h1>
          <p>
            Book flights quickly and easily with SkyGate International Airport
          </p>

          <!-- Form Section -->
          <div class="form-container mt-5">
            <form action="{{ route('flights.search') }}" method="GET" class="row g-4 align-items-end">
                <!-- Departure -->
                <div class="col-md-6 col-lg-4">
                    <label for="departure_airport" class="form-label text-secondary small mb-1 fw-bold">
                        <i class="fas fa-plane-departure me-2"></i>Departure From
                    </label>
                    <select id="departure_airport" name="departure_airport" class="form-select form-select-lg border-2 py-3" required>
                        <option value="" selected disabled>Select City</option>
                        @foreach(App\Models\Airport::all() as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->city }} - {{ $airport->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Arrival -->
                <div class="col-md-6 col-lg-4">
                    <label for="arrival_airport" class="form-label text-secondary small mb-1 fw-bold">
                        <i class="fas fa-plane-arrival me-2"></i>Arrival To
                    </label>
                    <select id="arrival_airport" name="arrival_airport" class="form-select form-select-lg border-2 py-3" required>
                        <option value="" selected disabled>Select City</option>
                        @foreach(App\Models\Airport::all() as $airport)
                            <option value="{{ $airport->iata_code }}">{{ $airport->city }} - {{ $airport->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div class="col-md-6 col-lg-4">
                    <label for="date" class="form-label text-secondary small mb-1 fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>Travel Date
                    </label>
                    <input type="date" id="date" name="date" class="form-control form-control-lg border-2 py-3 form-select" required min="{{ date('Y-m-d') }}">

                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold"
                        style="transition: all 0.3s"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px rgba(59,130,246,0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Search Flights
                        <i class="fas fa-search ms-2"></i>
                    </button>
                </div>
            </form>
        </div>

        </div>
      </section>
      <!--     Maskapai -->
      <section class="py-5">
        <div class="container">
          <div class="row g-4">
            <!-- Left Side - Services -->
           <div class="col-md-6">
            <h2 class="mb-4">🛫 Our Services</h2>
            <div class="row g-4">
                <!-- 24/7 Support -->
                <div class="col-md-4 col-lg-6">
                    <div class="card h-100 shadow-lg rounded-4 border-0 service-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-headset fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold">24/7 Support</h5>
                            <p class="card-text text-muted">
                                Our dedicated team is available round the clock to assist you with any inquiries.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Secure Payment -->
                <div class="col-md-4 col-lg-6">
                    <div class="card h-100 shadow-lg rounded-4 border-0 service-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-shield-alt fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title fw-bold">Secure Payment</h5>
                            <p class="card-text text-muted">
                                Multiple payment options with advanced encryption to protect your transactions.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Attractive Promotions -->
                <div class="col-md-4 col-lg-6">
                    <div class="card h-100 shadow-lg rounded-4 border-0 service-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-tags fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title fw-bold">Attractive Promotions</h5>
                            <p class="card-text text-muted">
                                Enjoy exclusive discounts up to 70% and special seasonal offers.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Premium Quality (New) -->
                <div class="col-md-4 col-lg-6">
                    <div class="card h-100 shadow-lg rounded-4 border-0 service-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-ticket-alt fa-3x text-purple"></i>
                            </div>
                            <h5 class="card-title fw-bold">Seamless Ticketing</h5>
                            <p class="card-text text-muted">
                                We provide top-notch e-ticketing services for a seamless travel experience.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            </div>
            <div class="col-md-6 d-flex flex-column" style="min-height: 100%;">
                <h2 class="mb-4">🛬 Partner Airlines</h2>
                <div class="card shadow-sm flex-grow-1">
                    <div class="card-body d-flex flex-column">
                        <div class="row g-3 justify-content-center flex-grow-1">
                            @foreach ($logos->take(9) as $logo)
                                <div class="col-4 text-center">
                                    <div class="card border-0 shadow-sm p-4 logo-card"
                                        style="border-radius: 20px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(10px);">
                                        <img
                                            src="{{ asset('storage/' . $logo) }}"
                                            alt="Logo Maskapai"
                                            class="img-fluid"
                                            style="max-height: 70px; transition: transform 0.3s ease, opacity 0.3s ease;"
                                        />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#allAirlinesModal"
                                style="border-radius: 30px; background: #003385; border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                View all Partner Airlines
                                <i class="fas fa-arrow-right ms-2" style="transition: transform 0.3s ease;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


          </div>
        </div>
      </section>

      <section style="background: white" class="destination-section py-5">
        <div class="container">
          <h2 class="mb-4">
            🌍 Get Ready to Fly, From Asia to the World 🌍
          </h2>
          <div class="row g-4">
            @foreach ($airports->take(6) as $airport)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card card-custom">
                        <img
                            src="{{ asset('storage/' . $airport->image) }}"
                            class="card-img h-100"
                            alt="{{ $airport->name }}"
                        />
                        <div class="card-img-overlay card-img-overlay-custom d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-start">
                                <span class="badge d-inline-block px-3 py-2 text-white"
                                      style="font-size: 0.9rem; background-color: rgba(0, 51, 133, 0.8); border-radius: 0.375rem; width: auto;">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $airport->country }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-white mb-2">{{ $airport->city }}</h3>
                                <a
                                    style="background-color: #003285"
                                    class="btn text-white"
                                    href="{{ route('flights.index') }}"
                                >
                                    find your flight now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
      </section>
      <!-- Flight Listing Section -->
      <section class="flight-listing py-5 bg-light">
        <div class="container">
          <h2 class="mb-5 text-left fw-bold display-6">
            ✈️ Explore the Sky With Us
          </h2>

          <!-- Flight Card 1 -->
          <div class="row mb-4">
            @foreach($flights as $flight)
                <div class="col-12 mb-3">
                    <div class="flight-card card shadow-lg border-0 hover-effect">
                        <div class="card-body p-4">
                            <!-- Airline Header -->
                            <div class="airline-header d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="airline-logo me-3">
                                        <div class="d-flex justify-content-center align-items-center rounded-circle shadow"
                                            style="width: 80px; height: 80px; background-color: #fff; border: 2px solid #e0e0e0; overflow: hidden;">
                                            <img src="{{ asset('storage/' . ($flight->airline->logo ?? 'airlines/default.png')) }}"
                                                alt="{{ $flight->airline->name ?? 'Airline' }} Logo"
                                                class="img-fluid"
                                                style="max-width: 70%; height: auto;" />
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="airline-name h4 mb-0">{{ $flight->airline->name ?? 'Unknown Airline' }}</h3>
                                        <small class="text-muted">Flight {{ $flight->flight_number ?? 'Unknown' }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill me-1"></i>SkyTeam
                                </span>
                            </div>

                            <!-- Flight Details -->
                            <div class="row align-items-center">
                                <!-- Departure & Arrival -->
                                <div class="col-md-4">
                                    <div class="flight-time text-center">
                                        <div class="departure">
                                            @php
                                                $departureSegment = $flight->flightSegments->where('sequence', 1)->first();
                                                $departureTime = $departureSegment ? $departureSegment->time->format('H:i') : '00:00';
                                                $departureCode = $departureSegment && $departureSegment->airport ? $departureSegment->airport->iata_code : 'XXX';
                                            @endphp
                                            <div class="time h5">{{ $departureTime }}</div>
                                            <div class="airport-code text-muted">{{ $departureCode }}</div>
                                        </div>
                                        <div class="duration my-2">
                                            <span class="badge bg-light text-dark border">
                                                @php
                                                    $departureSegment = $flight->flightSegments->where('sequence', 1)->first();
                                                    $arrivalSegment = $flight->flightSegments->sortByDesc('sequence')->first();

                                                    if ($departureSegment && $arrivalSegment && $departureSegment->time && $arrivalSegment->time) {
                                                        $totalDuration = $arrivalSegment->time->diffInMinutes($departureSegment->time);
                                                        $hours = floor($totalDuration / 60);
                                                        $minutes = $totalDuration % 60;
                                                    } else {
                                                        $hours = 0;
                                                        $minutes = 0;
                                                    }
                                                @endphp
                                                <i class="bi bi-clock-history me-2"></i>{{ $hours }}j {{ $minutes }}m
                                            </span>
                                        </div>
                                        <div class="arrival">
                                            @php
                                                $arrivalSegment = $flight->flightSegments->sortByDesc('sequence')->first();
                                                $arrivalTime = $arrivalSegment ? $arrivalSegment->time->format('H:i') : '00:00';
                                                $arrivalCode = $arrivalSegment && $arrivalSegment->airport ? $arrivalSegment->airport->iata_code : 'XXX';
                                            @endphp
                                            <div class="time h5">{{ $arrivalTime }}</div>
                                            <div class="airport-code text-muted">{{ $arrivalCode }}</div>
                                        </div>
                                    </div>
                                </div>

                            <!-- Flight Features -->
                                <div class="col-md-4 border-start border-end position-relative">
                                    <div class="flight-features text-center py-3">
                                        <!-- Feature Tabs -->
                                        <div class="feature-tabs d-flex justify-content-center mb-4">
                                            <button class="btn btn-sm btn-outline-primary active px-3 rounded-pill me-2"
                                                    data-bs-toggle="tab" data-bs-target="#amenities-{{ $flight->id }}">
                                                <i class="bi bi-grid me-1"></i>Facility
                                            </button>
                                        </div>
                                        <!-- Tab Content -->
                                        <div class="tab-content">
                                            <!-- Amenities Tab -->
                                            <div class="tab-pane fade show active" id="amenities-{{ $flight->id }}">
                                                <div class="features-grid row g-2 mb-4">
                                                    @php
                                                        // Mapping fasilitas ke ikon yang sesuai
                                                        $facilityIcons = [
                                                            'Wi-Fi' => ['icon_class' => 'bi-wifi', 'icon_color' => 'text-primary'],
                                                            'Power Port' => ['icon_class' => 'bi-plug', 'icon_color' => 'text-warning'],
                                                            'In-Flight Entertainment' => ['icon_class' => 'bi-tv', 'icon_color' => 'text-info'],
                                                            'Complimentary Snacks' => ['icon_class' => 'bi-cup-hot', 'icon_color' => 'text-danger'],
                                                            'Priority Boarding' => ['icon_class' => 'bi-hourglass-split', 'icon_color' => 'text-success'],
                                                            'Exclusive Lounge Access' => ['icon_class' => 'bi-door-open', 'icon_color' => 'text-secondary'],
                                                            'Onboard Shower' => ['icon_class' => 'bi-shower', 'icon_color' => 'text-primary'],
                                                        ];


                                                        // Fallback facilities if none exist in the database
                                                        $defaultFacilities = [
                                                            ['name' => 'Wi-Fi', 'image' => '', 'description' => 'Internet Wi-Fi'],
                                                            ['name' => 'Power Port', 'image' => '', 'description' => 'Colokan listrik'],
                                                            ['name' => 'Hiburan', 'image' => '', 'description' => 'Hiburan dalam penerbangan'],
                                                            ['name' => 'Minuman', 'image' => '', 'description' => 'Minuman gratis']
                                                        ];

                                                        $facilities = $flight->facilities->count() > 0 ? $flight->facilities : collect($defaultFacilities);
                                                    @endphp
                                                    @foreach(collect($facilities)->unique('name') as $facility)
                                                        <div class="col-6">
                                                            <div class="feature-item p-2 bg-light rounded">
                                                                @php
                                                                    $facilityName = is_object($facility) ? $facility->name : $facility['name'];
                                                                    $iconData = $facilityIcons[$facilityName] ?? ['icon_class' => 'bi-check-circle', 'icon_color' => 'text-success'];
                                                                @endphp
                                                                <i class="bi {{ $iconData['icon_class'] }} {{ $iconData['icon_color'] }}"></i>
                                                                <small class="d-block mt-1">{{ $facilityName }}</small>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Seat Availability -->
                                        <div class="seat-availability mt-3">
                                            @php
                                                // Ambil total kursi dan kursi yang tersedia berdasarkan is_available
                                                $totalSeats = $flight->seats()->count();
                                                $availableSeats = $flight->seats()->where('is_available', true)->count();

                                                // Hitung persentase kursi yang sudah terisi
                                                $percentFilled = $totalSeats > 0 ? round((($totalSeats - $availableSeats) / $totalSeats) * 100) : 0;
                                            @endphp

                                            <div class="d-flex justify-content-between mb-2">
                                                <small class="text-muted">
                                                    <span class="text-danger fw-bold">{{ $availableSeats }} Seats</span>
                                                    <i class="bi bi-person-seat me-1"></i> Remaining
                                                </small>
                                                <small class="text-muted">{{ $percentFilled }}% Filled</small>
                                            </div>

                                            <div class="progress" style="height: 8px; border-radius: 4px">
                                                <div class="progress-bar bg-danger progress-bar-striped"
                                                    role="progressbar" style="width: {{ $percentFilled }}%"
                                                    aria-valuenow="{{ $percentFilled }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <small class="text-muted mt-2 d-block">
                                                <i class="bi bi-exclamation-triangle"></i> Prices may increase as seats become scarce.
                                            </small>
                                        </div>

                                    </div>
                                </div>

                                <!-- Price & Action -->
                                <div class="col-md-4">
                                    <div class="flight-price text-center mt-3 mt-md-0">
                                        @php
                                            $flightClass = $flight->flightClasses->first();
                                            $originalPrice = $flightClass->original_price ?? 1500000;
                                            $currentPrice = $flightClass->price ?? 1082000;
                                        @endphp
                                        <div class="price-comparison mb-2">
                                            <small class="text-muted text-decoration-line-through">IDR{{ number_format($originalPrice, 0, ',', ',') }}</small>
                                        </div>
                                        <div class="price-amount display-6 text-danger fw-bold">
                                            IDR{{ number_format($currentPrice, 0, ',', ',') }}
                                        </div>
                                        <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-gradient-primary btn-lg mt-3 px-5 rounded-pill">
                                            <i class="bi bi-credit-card me-2"></i>Choose Flight
                                        </a>
                                        <div class="mt-2">
                                            <a href="#" class="text-decoration-none">
                                                <i class="bi bi-heart"></i> Simpan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

          </div>

          <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('flights.index') }}" class="btn btn-outline-primary btn-lg px-5 rounded-pill">
                    View More Flights
                    <i class="bi bi-arrow-down-circle ms-2"></i>
                  </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Modal -->
    <div class="modal fade" id="allAirlinesModal" tabindex="-1" aria-labelledby="allAirlinesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header" style="background: #003385; color: #fff;">
                    <h5 class="modal-title" id="allAirlinesModalLabel">✈️ All Partner Airlines</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-center justify-content-center">
                        @foreach ($logos as $logo)
                            <div class="col-6 col-md-4 col-lg-3 text-center">
                                <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                                    <img
                                        src="{{ asset('storage/' . $logo) }}"
                                        alt="Logo Maskapai"
                                        class="img-fluid"
                                        style="max-height: 70px; object-fit: contain;"
                                    />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 25px; padding: 8px 20px;">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
