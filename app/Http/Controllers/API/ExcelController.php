<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ExcelController extends Controller
{
    // funcion para procesar el excel enviado desde el front
    public function procesarExcel(Request $request)
    {
        // Validar que se envíe un archivo
        $validator = Validator::make($request->all(), [
            'excel' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Procesar el archivo usando la importación personalizada
            Excel::import(new ExcelImport, $request->file('excel'));
            return response()->json(['message' => 'Archivo procesado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando el archivo: ' . $e->getMessage()], 500);
        }
    }
}
