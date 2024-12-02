<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserNote;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UserNoteController extends Controller
{
    // Mostrar todas las notas de usuario
    public function index()
    {
        $currentUser = auth()->user(); 

        
        $userNotes = UserNote::where('usuario_id', $currentUser->userable->id_usuario)->get();

        return response()->json($userNotes);
    }


    // Mostrar una nota específica por su ID
    public function show($id)
    {
        
        $userNote = UserNote::find($id);

        if (!$userNote) {
            return response()->json([
                'message' => 'Nota de usuario no encontrada.',
            ], 404);
        }

        return response()->json($userNote);
    }

    // Crear una nueva nota de usuario
    public function store(Request $request)
    {

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuario,id_usuario', 
        ]);

        $userNote = new UserNote();
        $userNote->descripcion = $request->input('descripcion');
        $userNote->usuario_id = $request->input('usuario_id'); 
        $userNote->save();

        return response()->json([
            'message' => 'Nota de usuario creada con éxito.',
            'user_note' => $userNote,
        ], 201);
    }

    // Actualizar una nota existente de usuario
    public function update(Request $request, $id)
    {
        
        $userNote = UserNote::find($id);

        if (!$userNote) {
            return response()->json([
                'message' => 'Nota de usuario no encontrada.',
            ], 404);
        }

        
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        
        $userNote->descripcion = $request->input('descripcion');
        $userNote->save();

        return response()->json([
            'message' => 'Nota de usuario actualizada con éxito.',
            'user_note' => $userNote,
        ]);
    }

    // Eliminar una nota de usuario
    public function destroy($id)
    {
        
        $userNote = UserNote::find($id);

        if (!$userNote) {
            return response()->json([
                'message' => 'Nota de usuario no encontrada.',
            ], 404);
        }

        
        $userNote->delete();

        return response()->json([
            'message' => 'Nota de usuario eliminada con éxito.',
        ]);
    }
}
