<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_lastname' => 'required|string',
            'reservation_date' => 'required|date',
            'place_id' => 'required|integer'
        ]);

        Reservation::create($request->only(['client_name', 'client_lastname', 'reservation_date', 'place_id']));

        return response()->json(['message' => 'Reservation created successfully'], 201);
    }

    public function showForm()
    {
        return view('reservation-form');
    }
}
