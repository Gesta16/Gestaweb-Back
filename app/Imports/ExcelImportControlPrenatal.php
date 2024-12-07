<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ControlPrenatal;
use App\Models\ProcesoGestativo;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportControlPrenatal implements ToModel, WithStartRow
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
    private function buscarMetodoFracaso($metodo)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($metodo){
            case 'INYECTABLE TRIMESTRAL':
                return 1;
            case 'INYECTABLE MENSUAL':
                return 2;
            case 'ORAL (ACO)':
                return 3;
            case 'IMPLANTE SUBDERMICO':
                return 4;
            case 'DISPOSITIVO INTRAUTERINO (DIU T DE COBRE- HORMONAL)':
                return 5;
            case 'PRESERVATIVO':
                return 6;
            case 'EMERGENCIA':
                return 7;
            case 'ESTERILIZACIÓN':
                return 8;
            default:
                return 7;
                
        }
    }

    // funcion para convertir la fecha de excel a fecha valida para insertar
    private function convertirFecha($valor)
    {
        // Validar si es un número válido para fechas en Excel
        if (is_numeric($valor)) {
            return Date::excelToDateTimeObject($valor)->format('Y-m-d');
        }
        
        // Si no es un número, retornamos un texto indicando que no es válido
        return 'Formato de fecha inválido';
    }

    // funcion para la insercion de los datos
    public function model(array $row)
    {
        //\Log::info("entro_model");
        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {
            //\Log::info("entro_usuario_exis");
            
            $metodoFracaso = $this->buscarMetodoFracaso($row[26]);
            //\Log::info($metodoFracaso);
            $idProcesoGestativo = ProcesoGestativo::where('id_usuario', $usuarioExistente->id_usuario)->first();
            //\Log::info($idProcesoGestativo);

            //\Log::info("foreach", ['documento' => $row[27]]);

            try {
                //\Log::info("entro al try");
                ControlPrenatal::create([
                    'id_operador'                   => $this->operador, // 
                    'id_usuario'                    => $usuarioExistente->id_usuario, // $row[9] ?? 'No se encontro dato'
                    'proceso_gestativo_id'          => $idProcesoGestativo->id,
                    'edad_gestacional'              => ($row[20] ?? '') == '' ? 99.9 : $row[20],
                    'trim_ingreso'                  => $row[21] ?? 'No se encontro dato',
                    'fec_mestruacion'               => ($row[22] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[22]), // $row[22] ?? 'No se encontro dato'
                    'fec_parto'                     => ($row[23] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[23]), //  $row[23] ?? 'No se encontro dato'
                    'emb_planeado'                  => ($row[24] ?? 'null') == 'SI' ? true : false, // $row[24] ?? 'No se encontro dato'
                    'fec_anticonceptivo'            => ($row[25] ?? 'null') == 'SI' ? true : false, // $row[25] ?? 'No se encontro dato'
                    'cod_fracaso'                   => $metodoFracaso, // $row[26]
                    'fec_consulta'                  => ($row[27] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[27]), // $row[27] ?? 'No se encontro dato'
                    'fec_control'                   => ($row[28] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[28]), // $row[28] ?? 'No se encontro dato'
                    'ries_reproductivo'             => $row[29] ?? 'No se encontro dato',
                    'fac_asesoria'                  => ($row[30] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[30]), // $row[30] ?? 'No se encontro dato'
                    'usu_solicito'                  => ($row[31] ?? 'null') == 'SI' ? true : false, // $row[31] ?? 'No se encontro dato'
                    'fec_terminacion'               => ($row[32] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[32]),
                    'per_intergenesico'             => ($row[33] ?? 'null') == 'SI' ? true : false, //$row[33] ?? 'No se encontro dato'
    
                    'recibio_atencion_preconcep'    => ($row[27] ?? '') == '' ? false : true,
                    'asis_consul_control_precon'    => ($row[28] ?? '') == '' ? false : true,
                    'asis_asesoria_ive'             => ($row[31] ?? '') == '' ? false : true,
                    'tuvo_embarazos_antes'          => false,  
                ]);
                
            } catch (\Exception $e) {
                \Log::info("entro al catch");
                // Si ocurre un error, guarda el error y los datos en la variable de errores
                $this->errorData[] = [
                    'documento' => $row[9],  // El mensaje de error
                    'mensaje' => $e->getMessage(),  // Los datos que causaron el error
                ];
            }
            
        }
        return null;
    }
}

// $this->data[] = [
        //     'edad_gestacional'              => $row[20] ?? null,
        //     'trim_ingreso'                  => $row[21] ?? 'No se encontro dato',
        //     'fec_mestruacion'               => $row[22] ?? 'No se encontro dato',
        //     'fec_parto'                     => $row[23] ?? 'No se encontro dato',
        //     'emb_planeado'                  => $row[24] ?? 'No se encontro dato',
        //     'fec_anticonceptivo'            => $row[25] ?? 'No se encontro dato',
        //     'cod_fracaso'                   => $row[26] ?? 'No se encontro dato',
        //     'fec_consulta'                  => $row[27] ?? 'No se encontro dato',
        //     'fec_control'                   => $row[28] ?? 'No se encontro dato',
        //     'ries_reproductivo'             => $row[29] ?? 'No se encontro dato',
        //     'fac_asesoria'                  => $row[30] ?? 'No se encontro dato',
        //     'usu_solicito'                  => $row[31] ?? 'No se encontro dato', 
        //     'fec_terminacion'               => $row[32] ?? 'No se encontro dato',
        //     'per_intergenesico'             => $row[33] ?? 'No se encontro dato',

        //     'recibio_atencion_preconcep'    => false ?? 'No se encontro dato',
        //     'asis_consul_control_precon'    => true ?? 'No se encontro dato',
        //     'asis_asesoria_ive'             => true ?? 'No se encontro dato',
        //     'tuvo_embarazos_antes'          => false ?? 'No se encontro dato',     
        // ];