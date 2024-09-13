<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodoAnticonceptivo;

class MetodoAnticonceptivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MetodoAnticonceptivo = MetodoAnticonceptivo::orderBy('cod_metodo','asc')->get();

        return [
            'estado'=>'Ok',
            'Metodo Anticonceptivo'=>$MetodoAnticonceptivo
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
        $MetodoAnticonceptivo = MetodoAnticonceptivo::find($id);
    
        if ($MetodoAnticonceptivo) {
            return response()->json([
                'estado' => 'Ok',
                'Metodo Anticonceptivo' => $MetodoAnticonceptivo
            ], 200);
        } else {
            return response()->json([
                'error' => 'Metodo Anticonceptivo no encontrado'
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
