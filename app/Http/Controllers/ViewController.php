<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {

        $logos = Airline::inRandomOrder()->pluck('logo');
        $airports = Airport::inRandomOrder()->take(6)->get();
        $flights = Flight::with([
            'airline',
            'flightSegments.airport',
            'flightClasses',
            'facilities'
        ])->inRandomOrder()->take(3)->get();

        return view('components.index', compact('logos', 'airports','flights'));

    }
}
