<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NumSesionesCursoPaternidadMaternidad;

class NumSesionesCursoPaternidadMaternidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $NumSesionesCursoPaternidadMaternidad = NumSesionesCursoPaternidadMaternidad::orderBy('cod_sesiones','asc')->get();

        return [
            'estado'=>'Ok',
            'Sesiones_Curso'=>$NumSesionesCursoPaternidadMaternidad
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
        $NumSesionesCursoPaternidadMaternidad = NumSesionesCursoPaternidadMaternidad::find($id);
    
        if ($NumSesionesCursoPaternidadMaternidad) {
            return response()->json([
                'estado' => 'Ok',
                'Sesiones Curso Paternidad Maternidad' => $NumSesionesCursoPaternidadMaternidad
            ], 200);
        } else {
            return response()->json([
                'error' => 'Sesiones Curso Paternidad Maternidad no encontrado'
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
