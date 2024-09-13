<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PruebaNoTreponemicaRPR;


class PruebaNoTreponemicaRPRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PruebaNoTreponemicaRPR = PruebaNoTreponemicaRPR::orderBy('cod_rpr','asc')->get();

        return [
            'estado'=>'Ok',
            'Prueba no Treponemica RPR'=>$PruebaNoTreponemicaRPR
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
        $PruebaNoTreponemicaRPR = PruebaNoTreponemicaRPR::find($id);
    
        if ($PruebaNoTreponemicaRPR) {
            return response()->json([
                'estado' => 'Ok',
                'Prueba No Treponemica RPR' => $PruebaNoTreponemicaRPR
            ], 200);
        } else {
            return response()->json([
                'error' => 'Prueba No Treponemica RPR no encontrado'
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
