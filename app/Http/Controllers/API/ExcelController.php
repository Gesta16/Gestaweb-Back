<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use App\Imports\ExcelImportControlPrenatal;
use App\Imports\ExcelImportPrimeraConsulta;
use App\Imports\ExcelImportVacunacion;
use App\Imports\ExcelImportLaboratorio_1;
use App\Imports\ExcelImportLaboratorio_2;
use App\Imports\ExcelImportLaboratorio_3;
use App\Imports\ExcelImportITS;
use App\Imports\ExcelImportSeguimientoConsultaMensual;
use App\Imports\ExcelImportSeguimientoComplementario;
use App\Imports\ExcelImportMicronutriente;
use App\Imports\ExcelImportFinalizacionGestacion;
use App\Imports\ExcelImportLaboratorioIntraparto;
use App\Imports\ExcelImportSeguimientoGestantePostEvento;
use App\Imports\ExcelImportMortalidadPerinatal;
use App\Imports\ExcelImportDatosRecienNacido;
use App\Imports\ExcelImportTamizacionNeonatal;
use App\Imports\ExcelImportEstudioHipotiroidismo;
use App\Imports\ExcelImportRutaPYMS;
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
            'operador' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // tomamos y enviams el dato que nos llego del operador a la importacion
            $operador = $request->input('operador');

            // // importacion para los USUARIOS
            // $importUsuario = new ExcelImport();
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importUsuario, $request->file('excel'));

            // // importacion para los DATOS DE INGRESO A CONTROL PRENATAL
            // $importControlPrenatal = new ExcelImportControlPrenatal($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importControlPrenatal, $request->file('excel'));

            // // importacion para los DATOS DE PRIMERA CONSULTA
            // $importPrimeraConsulta = new ExcelImportPrimeraConsulta($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importPrimeraConsulta, $request->file('excel'));

            // // importacion para VACUNACION
            // $importVacunacion = new ExcelImportVacunacion($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importVacunacion, $request->file('excel'));

            // // importacion para LABORATORIO 1
            // $importLaboratorio_1 = new ExcelImportLaboratorio_1($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importLaboratorio_1, $request->file('excel'));

            // // importacion para LABORATORIO 2
            // $importLaboratorio_2 = new ExcelImportLaboratorio_2($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importLaboratorio_2, $request->file('excel'));

            // // importacion para LABORATORIO 3
            // $importLaboratorio_3 = new ExcelImportLaboratorio_3($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importLaboratorio_3, $request->file('excel'));

            // // importacion para ITS
            // $importITS = new ExcelImportITS($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importITS, $request->file('excel'));

            // // importacion para SEGUIMIENTO CONSULTA MENSUAL
            // $importSeguimientoConsulta = new ExcelImportSeguimientoConsultaMensual($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importSeguimientoConsulta, $request->file('excel'));

            // // importacion para SEGUIMIENTO COMPLEMENTARIO
            // $importSeguimientoComplementario = new ExcelImportSeguimientoComplementario($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importSeguimientoComplementario, $request->file('excel'));

            // // importacion para MICRONUTRIENTES
            // $importMicronutriente = new ExcelImportMicronutriente($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importMicronutriente, $request->file('excel'));

            // // importacion para FINALIZACION GESTACION
            // $importFinalizacionGestacion = new ExcelImportFinalizacionGestacion($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importFinalizacionGestacion, $request->file('excel'));

            // // importacion para SEGUIMIENTO INTRAPRTO
            // $importLaboratorioIntraparto = new ExcelImportLaboratorioIntraparto($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importLaboratorioIntraparto, $request->file('excel'));

            // // importacion para SEGUIMEINTO GESTANTE POST EVENTO OBSTETRICO
            // $importSeguimientoPostEvento = new ExcelImportSeguimientoGestantePostEvento($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importSeguimientoPostEvento, $request->file('excel'));

            // // importacion para MORTALIDAD PERINATALA
            // $importMortalidadPerintal = new ExcelImportMortalidadPerinatal($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importMortalidadPerintal, $request->file('excel'));

            // // importacion para DATOS DEL RECIEN NACIDO
            // $importDatosRecienNacido = new ExcelImportDatosRecienNacido($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importDatosRecienNacido, $request->file('excel'));

            // // importacion para TAMIZACION NEONATAL
            // $importTamizacionNeonatal = new ExcelImportTamizacionNeonatal($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importTamizacionNeonatal, $request->file('excel'));

            // // importacion para ESTUDIO HIPOTIROIDISMO CONGENICO
            // $importEstudioHipotiroidismo = new ExcelImportEstudioHipotiroidismo($operador);
            // // Procesar el archivo usando la importación personalizada
            // Excel::import($importEstudioHipotiroidismo, $request->file('excel'));

            // importacion para RUTA PYMS
            $importRutaPYMS = new ExcelImportRutaPYMS($operador);
            // Procesar el archivo usando la importación personalizada
            Excel::import($importRutaPYMS, $request->file('excel'));


            return response()->json([
                // '1.errores' => $importUsuario->errorData,
                // '1.ips' => $importUsuario->ipsData,
                // '1departamentos' => $importUsuario->departData,
                // '1.municipios' => $importUsuario->municData,

                // '2.data' => $importControlPrenatal->errorData,

                // '3.data' => $importPrimeraConsulta->data,

                // '4.data' => $importVacunacion->data,

                // '5.data' => $importLaboratorio_1->data,

                // '6.data' => $importLaboratorio_2->data,

                // '7.data' => $importLaboratorio_3->data,

                // '8.data' => $importITS->data,

                // '9.data' => $importSeguimientoConsulta->data,

                // '10.data' => $importSeguimientoComplementario->data,

                // '11.data' => $importMicronutriente->data,

                // '12.data' => $importFinalizacionGestacion->data,

                // '13.data' => $importLaboratorioIntraparto->data,

                // '14.data' => $importSeguimientoPostEvento->data,

                //'15.data' => $importMortalidadPerintal->data,

                //'16.data' => $importDatosRecienNacido->data,

                //'17.data' => $importTamizacionNeonatal->data,

                //'18.data' => $importEstudioHipotiroidismo->data,

                '19.data' => $importRutaPYMS->data,


            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando el archivo: ' . $e->getMessage()], 500);
        }
    }
}
