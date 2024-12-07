<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\SeguimientoGestantePostObstetrico;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportSeguimientoGestantePostEvento implements ToModel, WithStartRow
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

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarAnticonceptivo($metodo)
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

    // funcion para la insercion de los datos
    public function model(array $row)
    {
        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {

            // buscamos el codigo del proceso gestativo que tenga la gestante
            $idProcesoGestativo = ProcesoGestativo::where('id_usuario', $usuarioExistente->id_usuario)->first();


            try {
                SeguimientoGestantePostObstetrico::create([
                    'id_operador'                   => $this->operador,
                    'id_usuario'                    => $usuarioExistente->id_usuario,
                    'proceso_gest_id'               => $idProcesoGestativo->id,

                    'con_egreso'             => $row[169] ?? 'No se encontro dato',
                    'fec_fallecimiento'      => ($row[170] ?? '') == '' ? null : $this->convertirFecha($row[170]),
                    'fec_planificacion'      => ($row[171] ?? '') == '' ? null : $this->convertirFecha($row[171]),
                    'cod_metodo'             => $this->buscarAnticonceptivo($row[172]),

                    'recib_aseso_anticonceptiva'    => ($row[172] ?? '') == '' ? false : true,
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
