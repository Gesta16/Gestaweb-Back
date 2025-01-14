<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SignoAlarma;
use Illuminate\Http\Request;
use App\Models\Usuario;

class SignoAlarmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signos_alarma = SignoAlarma::with('usuario:id_usuario,documento_usuario') // Solo traemos los campos necesarios
            ->select('id', 'nombre', 'descripcion', 'usuario_id')
            ->get()
            ->map(function ($signo) {
                return [
                    'id' => $signo->id,
                    'nombre' => $signo->nombre,
                    'descripcion' => $signo->descripcion,
                    'documento' => $signo->usuario ? $signo->usuario->documento_usuario : null,
                ];
            });

        return response()->json($signos_alarma, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'documento' => 'required|string'
        ]);

        // Verificar si el documento ya está registrado
        $usuario_id = Usuario::where('documento_usuario', $request->documento)->first();

        if (!$usuario_id) {
            return response()->json([
                'error' => 'Este documento no existe.'
            ], 403);
        }

        // Agregar el ID del usuario existente a los datos
        $signo_alarma = $request->all();
        $signo_alarma['usuario_id'] = $usuario_id->id_usuario;

        $data = SignoAlarma::create($signo_alarma);
         
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $signo_alarma = SignoAlarma::find($id);
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }

    public function alarmaUser($id)
    {
        $signo_alarma = SignoAlarma::where('usuario_id', $id)->get();

        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string'
        ]);

        $signo_alarma = SignoAlarma::find($id);
        $signo_alarma->update($request->all());
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $signo_alarma = SignoAlarma::find($id);
        $signo_alarma->delete();
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }
}
