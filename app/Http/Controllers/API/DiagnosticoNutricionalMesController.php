<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiagnosticoNutricionalMes;

class DiagnosticoNutricionalMesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DiagnosticoNutricionalMes = DiagnosticoNutricionalMes::orderBy('cod_diagnostico','asc')->get();

        return [
            'estado'=>'Ok',
            'diagnostico'=>$DiagnosticoNutricionalMes
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
        $DiagnosticoNutricionalMes = DiagnosticoNutricionalMes::find($id);
    
        if ($DiagnosticoNutricionalMes) {
            return response()->json([
                'estado' => 'Ok',
                'Diagnostico nutricional mes' => $DiagnosticoNutricionalMes
            ], 200);
        } else {
            return response()->json([
                'error' => 'Diagnostico nutricional mes no encontrado'
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
