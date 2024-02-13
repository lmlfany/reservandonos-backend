<?php

namespace App\Http\Controllers;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function like(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'place_id' => 'required|exists:places,id',
        ]);

        // Nueva instancia y guardar el like
        Interaction::create([
            'place_id' => $request->place_id,
            'user_id' => auth()->id(),
        ]);

        // Devolver una respuesta
        return response()->json(['message' => 'Like guardado con éxito']);
    }

    // Eliminar un like
    public function unlike(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
        ]);

        // Buscar y eliminar el like
        Interaction::where('place_id', $request->place_id)
                   ->where('user_id', auth()->id()) // Opcional: Si deseas verificar qué usuario dio like
                   ->delete();

        return response()->json(['message' => 'Like eliminado con éxito']);
    }
}
