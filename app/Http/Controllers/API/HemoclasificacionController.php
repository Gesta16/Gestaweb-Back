<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hemoclasificacion;

class HemoclasificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Hemoclasificacion = Hemoclasificacion::orderBy('cod_hemoclasifi','asc')->get();

        return [
            'estado'=>'Ok',
            'Hemoclasificacion'=>$Hemoclasificacion
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
        $Hemoclasificacion = Hemoclasificacion::find($id);
    
        if ($Hemoclasificacion) {
            return response()->json([
                'estado' => 'Ok',
                'Hemoclasificacion' => $Hemoclasificacion
            ], 200);
        } else {
            return response()->json([
                'error' => 'Hemoclasificacion no encontrado'
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
