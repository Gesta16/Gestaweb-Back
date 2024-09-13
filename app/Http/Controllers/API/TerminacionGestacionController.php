<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TerminacionGestacion;

class TerminacionGestacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TerminacionGestacion = TerminacionGestacion::orderBy('cod_terminacion','asc')->get();

        return [
            'estado'=>'Ok',
            'Terminacion gestacion'=>$TerminacionGestacion
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
        $TerminacionGestacion = TerminacionGestacion::find($id);
    
        if ($TerminacionGestacion) {
            return response()->json([
                'estado' => 'Ok',
                'Terminacion gestacion' => $TerminacionGestacion
            ], 200);
        } else {
            return response()->json([
                'error' => 'Terminacion gestacion no encontrado'
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
