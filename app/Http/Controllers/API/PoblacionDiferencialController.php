<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PoblacionDiferencial;

class PoblacionDiferencialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poblacion = PoblacionDiferencial::orderBy('cod_poblacion','asc')->get();

        return [
            'estado'=>'Ok',
            'poblacion'=>$poblacion
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
        $PoblacionDiferencial = PoblacionDiferencial::find($id);
    
        if ($PoblacionDiferencial) {
            return response()->json([
                'estado' => 'Ok',
                'Poblacion Diferencial' => $PoblacionDiferencial
            ], 200);
        } else {
            return response()->json([
                'error' => 'Poblacion Diferencial no encontrada'
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
