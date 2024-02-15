<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LikeController extends Controller
{

    public function fetchInsert()
    {
               try {
            $places = Place::all();

            foreach ($places as $place) {
                $existingLike = Like::where('place_id', $place->id)->first();

                if (!$existingLike) {
                    Like::create([
                        'place_id' => $place->id,
                    ]);
                }
            }

            return response()->json(['message' => 'Registros de likes creados con éxito desde los place_id existentes en la tabla places']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al llenar los registros de likes desde los place_id existentes en la tabla places: ' . $e->getMessage()], 500);
        }
    }



    public function store(Request $request, $placeId){
        try {

            Like::create([
                'place_id' => $placeId,
            ]);

            return response()->json(['message' => '¡Has dado "me gusta" al lugar con éxito!']);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error al dar "me gusta" al lugar: ' . $e->getMessage()], 500);
        }
    }
}
