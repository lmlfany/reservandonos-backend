<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Place;
use App\Models\PlaceDetail;
use Illuminate\Validation\ValidationException;


class ReservationController extends Controller
{
    public function store(Request $request, $placeId)
    {
        try {
            $validatedData = $request->validate([
                'client_name' => 'required|string',
                'client_lastname' => 'required|string',
                'place_id' => 'required|integer',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required|date_format:H:i',
            ]);

            //Verificacion de reserva
            $existingReservation = Reservation::where('reservation_date', $validatedData['reservation_date'])
                ->where('reservation_time', $validatedData['reservation_time'])
                ->where('place_id', $validatedData['place_id'])
                ->first();

            if ($existingReservation) {
                return response()->json(['error' => 'Ya existe una reserva para esta fecha y lugar'], 400);
            }

            //Verificacion de cliente
            // $client = DB::table('reservations')
            //     ->whereRaw('LOWER(client_name) = ?', [strtolower($validatedData['client_name'])])
            //     // ->whereRaw('LOWER(client_lastname) = ?', [strtolower($validatedData['client_lastname'])])
            //     ->first();

            //     if (!$client) {
            //         $clientId = DB::table('reservations')->insertGetId([
            //             'client_name' => strtolower($validatedData['client_name']),
            //             // 'client_lastname' => strtolower($validatedData['client_lastname']),
            //         ]);
            //     } else {
            //         $clientId = $client->id;
            //     }





            $reservation = new Reservation();
            $reservation->client_name = $validatedData['client_name'];
            $reservation->client_lastname = $validatedData['client_lastname'];
            $reservation->reservation_date = $validatedData['reservation_date'];
            $reservation->reservation_time = $validatedData['reservation_time'];
            $reservation->place_id = $placeId;
            $reservation->save();

            return response()->json(['message' => 'Reserva creada exitosamente'], 201);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        }  catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showForm(Request $request)
    {
        $placeId = $request->query('placeId');
        $place = Place::findOrFail($placeId);
        $placeDetail = PlaceDetail::where('place_id', $placeId)->firstOrFail();
        return view('reservation-form', compact('place', 'placeDetail'));
    }


}
