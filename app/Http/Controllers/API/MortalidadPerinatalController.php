<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MortalidadPerinatal;

class MortalidadPerinatalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MortalidadPerinatal = MortalidadPerinatal::orderBy('cod_mortalidad','asc')->get();

        return [
            'estado'=>'Ok',
            'Mortalidad Perinatal'=>$MortalidadPerinatal
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
        $MortalidadPerinatal = MortalidadPerinatal::find($id);
    
        if ($MortalidadPerinatal) {
            return response()->json([
                'estado' => 'Ok',
                'Mortalidad Perinatal' => $MortalidadPerinatal
            ], 200);
        } else {
            return response()->json([
                'error' => 'Mortalidad Perinatal no encontrado'
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
