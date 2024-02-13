<?php

namespace App\Http\Controllers;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function like(Request $request)
{
    $request->validate([
        'place_id' => 'required|exists:places,id',
    ]);

    // Verificar si ya existe
    $existingInteraction = Interaction::where('place_id', $request->place_id)
                                       ->where('user_id', auth()->id())
                                       ->first();

    if ($existingInteraction) {
        return response()->json(['error' => 'Ya has dado like a este lugar previamente'], 422);
    }

    // Nueva interacción
    Interaction::create([
        'place_id' => $request->place_id,
        'user_id' => auth()->id(),
    ]);

    return response()->json(['message' => 'Like guardado con éxito']);
}

public function unlike(Request $request)
{
    $request->validate([
        'place_id' => 'required|exists:places,id',
    ]);

    // Buscar y eliminar
    $deleted = Interaction::where('place_id', $request->place_id)
                          ->where('user_id', auth()->id())
                          ->delete();

    if (!$deleted) {
        return response()->json(['error' => 'No se encontró ningún like para eliminar'], 404);
    }

    return response()->json(['message' => 'Like eliminado con éxito']);
}
}
