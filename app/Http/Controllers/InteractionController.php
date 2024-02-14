<?php

namespace App\Http\Controllers;
use App\Models\Interaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
        ]);

        try {
            $existingInteraction = Interaction::where('place_id', $request->place_id)
                                               ->where('user_id', Auth::id())
                                               ->first();

            if ($existingInteraction) {
                return response()->json(['error' => 'Ya has dado like a este lugar previamente'], 422);
            }

            Interaction::create([
                'place_id' => $request->place_id,
                'user_id' => Auth::id(),
            ]);

            return response()->json(['message' => 'Like guardado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el like: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar un like
    public function unlike(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
        ]);

        try {
            $deleted = Interaction::where('place_id', $request->place_id)
                                  ->where('user_id', Auth::id())
                                  ->delete();

            if (!$deleted) {
                return response()->json(['error' => 'No se encontró ningún like para eliminar'], 404);
            }

            return response()->json(['message' => 'Like eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el like: ' . $e->getMessage()], 500);
        }
    }
}
