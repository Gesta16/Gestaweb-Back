<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\PrimeraConsulta;
use App\Models\ProcesoGestativo;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportPrimeraConsulta implements ToModel, WithStartRow
{
    public $data = [];
    public $errorData = [];
    private $operador;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct($operador)
    {
        $this->operador = $operador;
    }

    // Especificar la fila de inicio
    public function startRow(): int
    {
        return 7;
    }

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarTipoDM($tipodm)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($tipodm){
            case 'TIPO I':
                return 1;
            case 'TIPO II':
                return 2;
            case 'TIPO II INSULINOREQUIRIENTE':
                return 3;
            default:
                return null;
        }
    }

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarClasificacionRiesgo($riesgo)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($riesgo){
            case 'MUY ALTO':
                return 1;
            case 'ALTO':
                return 2;
            case 'MODERADO':
                return 3;
            case 'BAJO':
                return 4;
            default:
                return 4;
        }
    }

    // funcion para convertir la fecha de excel a fecha valida para insertar
    private function convertirFecha($fecha)
    {
        // Validar si es un número válido para fechas en Excel
        if (is_numeric($fecha)) {
            return Date::excelToDateTimeObject($fecha)->format('Y-m-d');
        }
        
        // Si no es un número, retornamos un texto indicando que no es válido
        return 'Formato de fecha inválido';
    }

    // funcion para la insercion de los datos
    public function model(array $row)
    {
        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {

            // buscamos el codigo del proceso gestativo que tenga la gestante
            $idProcesoGestativo = ProcesoGestativo::where('id_usuario', $usuarioExistente->id_usuario)->first();

            // llamamos a la funcion que busca el id de claisificacion de riesgo
            $clasificacionRiesgo = $this->buscarClasificacionRiesgo($row[41]);

            try {
                PrimeraConsulta::create([

                    'id_operador'               => $this->operador,
                    'id_usuario'                => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'      => $idProcesoGestativo->id,

                    'peso_previo'               => $row[34] ?? 999,
                    'tal_consulta'              => $row[35] ?? 999.9,
                    'imc_consulta'              => ($row[36] ?? 'null') === 'SI' ? 1 : 0, // $row[36] ?? 'No se encontro dato'
                    'diag_nutricional'          => $row[37] ?? 'No se encontro dato',
                    'hta'                       => ($row[38] ?? 'null') === 'SI' ? 1 : 0, //  $row[38] ?? 'No se encontro dato'
                    'dm'                        => ($row[39] ?? 'null') === 'SI' ? 1 : 0, // $row[39] ?? 'No se encontro dato'  integer
                    'cod_dm'                    => ($row[40] ?? '') == '' ? null : $this->buscarTipoDM($row[40]), // PUEDE NULL $row[40] ?? null 
                    'cod_riesgo'                => $clasificacionRiesgo, //  $row[41]
                    'fact_riesgo'               => $row[42] ?? 'No se encontro dato',
                    'expo_violencia'            => $row[43] ?? 'No se encontro dato',
                    'ries_depresion'            => $row[44] ?? 'No se encontro dato',

                    'for_gestacion'             => $row[45] ?? 0,
                    'for_parto'                 => $row[46] ?? 0,
                    'for_cesarea'               => $row[47] ?? 0,
                    'for_aborto'                => $row[48] ?? 0,
                    
                    'fec_lactancia'             => ($row[49] ?? '') == '' ? null : $this->convertirFecha($row[49]), // $row[49] ?? null PUEDE NULL 
                    'fec_consejeria'            => ($row[50] ?? '') == '' ? null : $this->convertirFecha($row[50]), // $row[50] ?? null PUEDE NULL

                    'asis_conse_lactancia'      => ($row[49] ?? '') == '' ? false : true,
                    'asis_conse_pre_vih'        => ($row[50] ?? '') == '' ? false : true,
                ]);

            } catch (\Exception $e) {
                // Si ocurre un error, guarda el error y los datos en la variable de errores
                $errorData[] = [
                    'documento' => $row[9],  // El mensaje de error
                    'mensaje' => $e->getMessage(),  // Los datos que causaron el error
                ];
                $this->data[] = $errorData;
            }
        }
        return null;
    }
}

// $this->data[] = [
//             'operador'  => $this->operador,
//             'edad_gestacional'              => $row[34] ?? null,
//             'trim_ingreso'                  => $row[35] ?? 'No se encontro dato',
//             'fec_mestruacion'               => $row[36] ?? 'No se encontro dato',
//             'fec_parto'                     => $row[37] ?? 'No se encontro dato',
//             'emb_planeado'                  => $row[38] ?? 'No se encontro dato',
//             'fec_anticonceptivo'            => $row[39] ?? 'No se encontro dato',
//             'cod_fracaso'                   => $row[40] ?? 'No se encontro dato',
//             'fec_consulta'                  => $row[41] ?? 'No se encontro dato',
//             'fec_control'                   => $row[42] ?? 'No se encontro dato',
//             'ries_reproductivo'             => $row[43] ?? 'No se encontro dato',
//             'fac_asesoria'                  => $row[44] ?? 'No se encontro dato',
//             'usu_solicito'                  => $row[45] ?? 'No se encontro dato', 
//             'fec_terminacion'               => $row[46] ?? 'No se encontro dato',
//             'per_intergenesico'             => $row[47] ?? 'No se encontro dato',
//             'per_intergenesico1'            => $row[48] ?? 'No se encontro dato',
//             'per_intergenesico2'            => $row[49] ?? 'No se encontro dato',
//             'per_intergenesico3'            => $row[50] ?? 'No se encontro dato',


//             'recibio_atencion_preconcep'    => false ?? 'No se encontro dato',
//             'asis_consul_control_precon'    => true ?? 'No se encontro dato',
//             'asis_asesoria_ive'             => true ?? 'No se encontro dato',
//             'tuvo_embarazos_antes'          => false ?? 'No se encontro dato',     
//         ];