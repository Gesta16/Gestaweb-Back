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
            $import = new ExcelImport();
            // Procesar el archivo usando la importación personalizada
            Excel::import($import, $request->file('excel'));
            //$datos = $import->data;

            return response()->json([
                'errores' => $import->errorData,
                'ips' => $import->ipsData,
                'departamentos' => $import->departData,
                'municipios' => $import->municData,
                
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando el archivo: ' . $e->getMessage()], 500);
        }
    }
}
