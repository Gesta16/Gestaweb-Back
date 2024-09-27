<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodoFracaso;

class MetodoFracasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metodoFracaso = MetodoFracaso::orderBy('cod_fracaso','asc')->get();

        return [
            'estado'=>'Ok',
            'metodo'=>$metodoFracaso
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
        $MetodoFracaso = MetodoFracaso::find($id);
    
        if ($MetodoFracaso) {
            return response()->json([
                'estado' => 'Ok',
                'Metodo Fracaso' => $MetodoFracaso
            ], 200);
        } else {
            return response()->json([
                'error' => 'Metodo Fracaso no encontrada'
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
