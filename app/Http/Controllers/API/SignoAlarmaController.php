<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SignoAlarma;
use Illuminate\Http\Request;

class SignoAlarmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signos_alarma = SignoAlarma::all();
        return response()->json([
            'estado' => 'Ok',
            'signos_alarma' => $signos_alarma
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'consejo' => 'required|string'
        ]);

        $data = SignoAlarma::create($request->all());
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $signo_alarma = SignoAlarma::find($id);
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'consejo' => 'required|string'
        ]);

        $signo_alarma = SignoAlarma::find($id);
        $signo_alarma->update($request->all());
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $signo_alarma = SignoAlarma::find($id);
        $signo_alarma->delete();
        return response()->json([
            'estado' => 'Ok',
            'signo_alarma' => $signo_alarma
        ], 200);
    }
}
