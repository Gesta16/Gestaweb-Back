<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Municipio;


class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cod_departamento)
    {
        // Realizar la búsqueda de municipios por departamento
        $municipios = DB::table('municipio')
                        ->join('departamento', 'municipio.cod_departamento', '=', 'departamento.cod_departamento')
                        ->select('municipio.*', 'departamento.nom_departamento')
                        ->where('municipio.cod_departamento', $cod_departamento)
                        ->get();
    

        return response()->json([
            'estado' => 'Ok',
            'Municipios' => $municipios
        ], 200);
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
        $Municipio = Municipio::find($id);
    
        if ($Municipio) {
            return response()->json([
                'estado' => 'Ok',
                'Municipio' => $Municipio
            ], 200);
        } else {
            return response()->json([
                'error' => 'Municipio no encontrado'
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
