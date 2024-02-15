<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function fetchInsert()
    {
        try {
            $placeIds = Place::pluck('id');

            foreach ($placeIds as $placeId) {
                Like::updateOrCreate(['place_id' => $placeId], ['likes_count' => 0]);
            }

            return response()->json(['message' => 'Registros de likes creados con éxito para los IDs de place existentes']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear registros de likes: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request, $placeId)
    {
        try {
            DB::table('likes')->updateOrInsert(
                ['place_id' => $placeId],
                ['likes_count' => DB::raw('likes_count + 1')]
            );

            return response()->json(['message' => '¡Has dado "me gusta" al lugar con éxito!']);
        } catch (\Exception $e) {
            Log::error('Error al dar "me gusta" al lugar: ' . $e->getMessage());
            return response()->json(['error' => 'Error al dar "me gusta" al lugar'], 500);
        }
    }
}
