<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormaMedicionEdadGestacional;

class FormaMedicionEdadGestacionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $FormaMedicionEdadGestacional = FormaMedicionEdadGestacional::orderBy('cod_medicion','asc')->get();

        return [
            'estado'=>'Ok',
            'Forma_Medicion'=>$FormaMedicionEdadGestacional
        ];  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $FormaMedicionEdadGestacional = FormaMedicionEdadGestacional::find($id);
    
        if ($FormaMedicionEdadGestacional) {
            return response()->json([
                'estado' => 'Ok',
                'Forma Medicion Edad Gestacional' => $FormaMedicionEdadGestacional
            ], 200);
        } else {
            return response()->json([
                'error' => 'Forma Medicion Edad Gestacional no encontrado'
            ], 404);
        } 
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
