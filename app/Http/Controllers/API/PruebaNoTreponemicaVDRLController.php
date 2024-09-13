<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PruebaNoTreponemicaVDRL;

class PruebaNoTreponemicaVDRLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PruebaNoTreponemicaVDRL = PruebaNoTreponemicaVDRL::orderBy('cod_vdrl','asc')->get();

        return [
            'estado'=>'Ok',
            'Prueba No Treponemica VDRL'=>$PruebaNoTreponemicaVDRL
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
        $PruebaNoTreponemicaVDRL = PruebaNoTreponemicaVDRL::find($id);
    
        if ($PruebaNoTreponemicaVDRL) {
            return response()->json([
                'estado' => 'Ok',
                'Prueba No Treponemica VDRL' => $PruebaNoTreponemicaVDRL
            ], 200);
        } else {
            return response()->json([
                'error' => 'Prueba No Treponemica VDRL no encontrado'
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
