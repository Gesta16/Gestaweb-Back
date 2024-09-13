<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PruebaNoTreponemicaRecienNacido;

class PruebaNoTreponemicaRecienNacidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PruebaNoTreponemicaRecienNacido = PruebaNoTreponemicaRecienNacido::orderBy('cod_treponemica','asc')->get();

        return [
            'estado'=>'Ok',
            'Prueba No Treponemica Recien Nacido'=>$PruebaNoTreponemicaRecienNacido
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
        $PruebaNoTreponemicaRecienNacido = PruebaNoTreponemicaRecienNacido::find($id);
    
        if ($PruebaNoTreponemicaRecienNacido) {
            return response()->json([
                'estado' => 'Ok',
                'Prueba No Treponemica Recien Nacido' => $PruebaNoTreponemicaRecienNacido
            ], 200);
        } else {
            return response()->json([
                'error' => 'Prueba No Treponemica Recien Nacido no encontrado'
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
