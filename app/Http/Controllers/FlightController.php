<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Facility;
use App\Models\FlightClass;
use App\Models\FlightSeat;
use App\Models\PromoCode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::query();
        $query->whereHas('flightSegments', function ($q) {
            $q->where('time', '>=', now());
        });
        // Mengambil 3 penerbangan acak dengan semua relasi yang diperlukan
        $flights = Flight::with([
            'airline',
            'flightSegments.airport',
            'flightClasses',
            'facilities',
            'seats' => function($query) {
                $query->where('is_available', true);
            }
        ])->inRandomOrder()->get();

        // Mengambil semua maskapai dengan jumlah penerbangan
        $airlines = Airline::withCount('flights')->get();

        // Mengambil semua fasilitas dengan jumlah penerbangan
        $facilities = Facility::withCount('flights')->get();
        // Filter berdasarkan harga
        if ($request->has('max_price')) {
            $query->whereHas('flightClasses', function($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        // Filter berdasarkan jenis penerbangan (direct, 1 transit, 2+ transit)
        if ($request->has('flight_type')) {
            if (in_array('direct', $request->flight_type)) {
                $query->has('flightSegments', '=', 2);
            } elseif (in_array('1_stop', $request->flight_type)) {
                $query->has('flightSegments', '=', 3);
            } elseif (in_array('2plus_stops', $request->flight_type)) {
                $query->has('flightSegments', '>=', 4);
            }
        }

        // Filter berdasarkan maskapai
        if ($request->has('airlines')) {
            $query->whereIn('airline_id', $request->airlines);
        }

        // Filter berdasarkan fasilitas
        if ($request->has('facilities')) {
            $query->whereHas('facilities', function($q) use ($request) {
                $q->whereIn('facilities.id', $request->facilities);
            });
        }

        $flights = $query->with([
            'airline',
            'flightSegments' => function($query) {
                // $query->orderBy('sequence', 'asc');
                $query->orderBy('time', 'asc');
            },
            'flightSegments.airport',
            'flightClasses',
            'facilities',
            'seats' => function($query) {
                $query->where('is_available', true);
            }
        ])->orderByRaw("(SELECT MIN(time) FROM flight_segments WHERE flight_segments.flight_id = flights.id) ASC")
        ->get();

        $airlines = Airline::withCount('flights')->get();
        $facilities = Facility::withCount('flights')->get();


        return view('flights.index', compact('flights', 'airlines', 'facilities', 'request'));
    }

    public function search(Request $request)
    {
        $query = Flight::query();

        // Filter berdasarkan bandara keberangkatan
        if ($request->filled('departure_airport')) {
            $query->whereHas('flightSegments', function($q) use ($request) {
                $q->where('sequence', 1)
                ->whereHas('airport', function($a) use ($request) {
                    $a->where('iata_code', $request->departure_airport);
                });
            });
        }

        // Filter berdasarkan bandara tujuan
        if ($request->filled('arrival_airport')) {
            $query->whereHas('flightSegments', function($q) use ($request) {
                $q->whereHas('airport', function($a) use ($request) {
                    $a->where('iata_code', $request->arrival_airport);
                });
            })->whereDoesntHave('flightSegments', function($q) use ($request) {
                $q->where('sequence', 1)
                ->whereHas('airport', function($a) use ($request) {
                    $a->where('iata_code', $request->arrival_airport);
                });
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->whereHas('flightSegments', function($q) use ($date) {
                $q->where('sequence', 1)
                ->whereDate('time', $date);
            });
        }

        // Filter berdasarkan harga
        if ($request->filled('max_price')) {
            $query->whereHas('flightClasses', function($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        // Filter berdasarkan jenis penerbangan (direct, 1 transit, 2+ transit)
        if ($request->filled('flight_type')) {
            if (in_array('direct', $request->flight_type)) {
                $query->has('flightSegments', '=', 2);
            } elseif (in_array('1_stop', $request->flight_type)) {
                $query->has('flightSegments', '=', 3);
            } elseif (in_array('2plus_stops', $request->flight_type)) {
                $query->has('flightSegments', '>=', 4);
            }
        }

        // Filter berdasarkan maskapai
        if ($request->filled('airlines')) {
            $query->whereIn('airline_id', $request->airlines);
        }

        // Filter berdasarkan fasilitas
        if ($request->filled('facilities')) {
            $query->whereHas('facilities', function($q) use ($request) {
                $q->whereIn('facilities.id', $request->facilities);
            });
        }

        // Ambil hasil pencarian
        $flights = $query->with([
            'airline',
            'flightSegments' => function($query) {
                $query->orderBy('sequence', 'asc');
            },
            'flightSegments.airport',
            'flightClasses',
            'facilities',
            'seats' => function($query) {
                $query->where('is_available', true);
            }
        ])->get();

        // Ambil semua data maskapai & fasilitas tanpa filter
        $airlines = Airline::all();
        $facilities = Facility::all();

        return view('flights.search', compact('flights', 'airlines', 'facilities', 'request'));
    }


    public function show($id)
    {
        $flight = Flight::with([
            'airline',
            'flightSegments' => function($query) {
                $query->orderBy('sequence', 'asc');
            },
            'flightSegments.airport',
            'flightClasses.facilities',
            'facilities',
            'seats' => function($query) {
                $query->where('is_available', true);
            }
        ])->findOrFail($id);

        // Mengambil promo yang masih berlaku
        $validPromos = PromoCode::where('valid_until', '>', now())
                                ->where('is_used', false)
                                ->get();

        return view('flights.show', compact('flight', 'validPromos'));
    }

    public function bookingForm($id, Request $request)
    {
        // Validate request parameters
        $request->validate([
            'class_type' => 'required|string',
            'passengers' => 'required|integer|min:1|max:10',
        ]);

        // Retrieve flight with necessary relationships
        $flight = Flight::with([
            'airline',
            'flightSegments.airport',
            'flightClasses' => function($query) use ($request) {
                $query->where('class_type', $request->class_type);
            },
            'facilities',
            'seats' => function($query) use ($request) {
                $query->where('class_type', $request->class_type);
            }
        ])->findOrFail($id);

        $selectedClass = $flight->flightClasses->first();

        if (!$selectedClass) {
            return redirect()->back()->with('error', 'Selected class is not available for this flight.');
        }

        // Check if there are enough available seats
        if ($flight->seats->count() < $request->passengers) {
            return redirect()->back()->with('error', 'Not enough seats available for the requested number of passengers.');
        }

        return view('flights.booking', compact('flight', 'selectedClass'));
    }

    public function processBooking($id, Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.date_of_birth' => 'required|date',
            'passengers.*.nationality' => 'required|string|max:100',
            'passengers.*.seat_id' => 'required|exists:flight_seats,id',
            'promo_code' => 'nullable|string', // Accept promo code as a string
        ]);

        // Fetch flight and related data
        $flight = Flight::with(['flightClasses', 'seats'])->findOrFail($id);
        $selectedClass = $flight->flightClasses->where('id', $request->flight_class_id)->first();

        if (!$selectedClass) {
            return redirect()->back()->with('error', 'Selected class is not available.');
        }

        // Check if customer is logged in
        $customer = Auth::guard('customers')->user();
        if (!$customer) {
            return redirect()->route('login')->with('error', 'You must be logged in to book a flight.');
        }

        // Validate seat availability
        foreach ($request->passengers as $passenger) {
            $seat = FlightSeat::find($passenger['seat_id']);
            if (!$seat || !$seat->is_available || $seat->flight_id != $flight->id) {
                return redirect()->back()->with('error', "Seat {$passenger['seat_id']} is not available.");
            }
        }

        // Calculate subtotal (price before discount)
        $subtotal = $selectedClass->price * count($request->passengers);
        $discount = 0;

        // Check and apply promo code discount
        if ($request->promo_code) {
            // Resolve promo code from string to ID
            $promo = PromoCode::where('code', $request->promo_code)
                ->where('is_used', false)
                ->where('valid_until', '>', now())
                ->first();

            if ($promo) {
                if ($promo->discount_type === 'percentage') {
                    // Calculate percentage discount
                    $discount = $subtotal * ($promo->discount / 100);
                } else {
                    // Fixed amount discount
                    $discount = $promo->discount;
                }

                // Ensure discount does not exceed subtotal
                $discount = min($discount, $subtotal);

                // Mark promo code as used
                $promo->is_used = true;
                $promo->save();
            } else {
                return redirect()->back()->with('error', 'Invalid or expired promo code.');
            }
        }

        // Calculate grand total (price after discount)
        $grandtotal = max(0, $subtotal - $discount);

        DB::beginTransaction();

        try {
            // Create transaction record
            $transaction = Transaction::create([
                'code' => 'TRX-' . time(),
                'flight_id' => $flight->id,
                'flight_class_id' => $selectedClass->id,
                'customer_id' => $customer->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'number_of_passengers' => count($request->passengers),
                'promo_code_id' => isset($promo) ? $promo->id : null,
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'grandtotal' => $grandtotal,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($request->passengers as $passengerData) {
                // Create passenger record
                $transaction->passengers()->create([
                    'flight_seat_id' => $passengerData['seat_id'],
                    'name' => $passengerData['name'],
                    'date_of_birth' => $passengerData['date_of_birth'],
                    'nationality' => $passengerData['nationality']
                ]);

                // Mark seat as unavailable
                FlightSeat::where('id', $passengerData['seat_id'])->update(['is_available' => false]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Booking error: " . $e->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again.");
        }

        return redirect()->route('transactions.payment', ['transaction' => $transaction->id])
            ->with('success', "Booking created successfully. Please complete your payment.");
    }


    public function validatePromoCode(Request $request)
    {
        $code = $request->input('code');

        $promoCode = PromoCode::where('code', $code)
            ->where('is_used', 0)
            ->where('valid_until', '>=', now())
            ->first();

        if ($promoCode) {
            return response()->json([
                'valid' => true,
                'discount_type' => $promoCode->discount_type,
                'discount' => $promoCode->discount,
                'description' => $promoCode->discount_type === 'percentage'
                    ? $promoCode->discount . '% off your booking'
                    : 'Rp ' . number_format($promoCode->discount, 0, ',', '.') . ' off your booking'
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Invalid promo code or promo code has expired'
        ]);
    }

    public function getFacilities(Request $request)
    {
        $classType = $request->input('class_type');
        $flightId = $request->input('flight_id');

        // Ambil flight dan fasilitas berdasarkan class yang dipilih
        $flight = Flight::with(['facilities' => function($query) use ($classType) {
            $query->where('class_type', $classType);
        }])->findOrFail($flightId);

        // Jika tidak ada fasilitas, tampilkan pesan kosong
        if ($flight->facilities->isEmpty()) {
            return '<div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>No specific facilities listed for this class.
                        </div>
                    </div>';
        }

        // Generate konten fasilitas
        $output = '';
        foreach ($flight->facilities as $facility) {
            $output .= '<div class="col-md-3 col-6">
                            <div class="facility-card bg-light p-3 text-center h-100">
                                <i class="bi '. ($facility->icon_class ?? 'bi-check-circle') .' text-primary fs-3 mb-2"></i>
                                <p class="mb-0">'. $facility->name .'</p>
                            </div>
                        </div>';
        }

        return $output;
    }

}
