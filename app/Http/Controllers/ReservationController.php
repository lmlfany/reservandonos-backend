<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Place;
use App\Models\PlaceDetail;
use App\Models\Client;
use App\Models\Like;
use Illuminate\Validation\ValidationException;


class ReservationController extends Controller
{
    public function store(Request $request, $placeId)
    {
        try {
            $validatedData = $request->validate([
                'place_id' => 'required|integer',
                'client_name' => 'required|string',
                'client_lastname' => 'required|string',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required|date_format:H:i',
            ]);

            $client_name = strtolower($validatedData['client_name']);
            $client_lastname = strtolower($validatedData['client_lastname']);

            $client = Client::where('name', $client_name)
                ->where('lastname', $client_lastname)
                ->first();

            if (!$client) {
                $client = new Client();
                $client->name = $client_name;
                $client->lastname = $client_lastname;
                $client->save();
            }


            //Verificacion de reserva
            $existingReservation = Reservation::where('reservation_date', $validatedData['reservation_date'])
                ->where('reservation_time', $validatedData['reservation_time'])
                ->where('place_id', $validatedData['place_id'])
                ->first();

            if ($existingReservation) {
                return response()->json(['error' => 'Ya existe una reserva para esta fecha y lugar'], 400);
            }


            $existingReservationClient = Reservation::where('reservation_date', $validatedData['reservation_date'])
                ->where('client_id', $client->id)
                ->first();

            if ($existingReservationClient) {
                return response()->json(['error' => 'El cliente ya tiene una reserva para esta fecha'], 400);
            }


            $reservation = new Reservation();
            $reservation->client_id = $client->id;
            $reservation->client_name = $validatedData['client_name'];
            $reservation->client_lastname = $validatedData['client_lastname'];
            $reservation->place_id = $placeId;
            $reservation->reservation_date = $validatedData['reservation_date'];
            $reservation->reservation_time = $validatedData['reservation_time'];
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

    public function topRestaurants()
    {
        // Cantidad total de reservaciones
        $topRestaurants = Place::select('places.*')
            ->selectRaw('COUNT(reservations.id) as total_reservations')
            ->leftJoin('reservations', 'places.id', '=', 'reservations.place_id')
            ->groupBy('places.id')
            ->orderByDesc('total_reservations')
            ->limit(5)
            ->get();

        // Cliente más frecuente
        foreach ($topRestaurants as $restaurant) {
            $mostFrequentClient = Reservation::select('client_id')
                ->selectRaw('COUNT(client_id) as reservation_count')
                ->where('place_id', $restaurant->id)
                ->groupBy('client_id')
                ->orderByDesc('reservation_count')
                ->first();

            if ($mostFrequentClient) {
                $client = Client::find($mostFrequentClient->client_id);
                $restaurant->most_frequent_client = $client ? $client->name . ' ' . $client->lastname : 'N/A';
            } else {
                $restaurant->most_frequent_client = 'N/A';
            }

            // Cantidad de likes
            $likeCount = Like::where('place_id', $restaurant->id)->value('likes_count');
            $restaurant->likes_count = $likeCount ?? 0;
        }

        return response()->json($topRestaurants);
    }

    public function showTop()
    {
        return view('top-restaurants');
    }

}
