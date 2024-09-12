<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riesgo;

class RiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Riesgo = Riesgo::orderBy('cod_riesgo','asc')->get();

        return [
            'estado'=>'Ok',
            'Riesgo'=>$Riesgo
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
        $Riesgo = Riesgo::find($id);
    
        if ($Riesgo) {
            return response()->json([
                'estado' => 'Ok',
                'Riesgo' => $Riesgo
            ], 200);
        } else {
            return response()->json([
                'error' => 'Riesgo no encontrado'
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
