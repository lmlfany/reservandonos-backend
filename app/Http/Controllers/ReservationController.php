<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

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

        //Verificacion de reserva
        $existingReservation = Reservation::where('reservation_date', $request->reservation_date)
            ->where('place_id', $request->place_id)
            ->first();

            if ($existingReservation) {
                return response()->json(['error' => 'Ya existe una reserva para esta fecha y lugar'], 400);
            }

        //Verificacion de cliente
        $client = DB::table('reservations')
            ->whereRaw('LOWER(client_name) = ?', [strtolower($request->client_name)])
            ->whereRaw('LOWER(client_lastname) = ?', [strtolower($request->client_lastname)])
            ->first();

            if (!$client) {
                $client = DB::table('reservations')->insertGetId([
                    'client_name' => strtolower($request->client_name),
                    'client_lastname' => strtolower($request->client_lastname),
                ]);
            }

        Reservation::create([
            'client_id' => $client->id,
            'reservation_date' => $request->reservation_date,
            'place_id' => $request->place_id
        ]);


        return response()->json(['message' => 'Reserva creada exitosamente'], 201);
    }

    public function showForm(Request $request)
    {
        $placeId = $request->query('placeId');
        return view('reservation-form', compact('placeId'));
    }


}
