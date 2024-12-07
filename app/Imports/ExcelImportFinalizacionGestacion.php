<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\FinalizacionGestacion;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportFinalizacionGestacion implements ToModel, WithStartRow
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

    // funcion para tomar el dato del tipo de parto (COLUMNA 160 o COLUMNA FD)
    private function buscarTipoParto($parto)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($parto){
            case 'PARTO VAGINAL':
                return 1;
            case 'CESAREA':
                return 2;
            case 'ABORTO':
                return 3;
            case 'MORTALIDAD PERINATAL':
                return 4;
            case 'IVE':
                return 5;
            default:
                return 1;
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
                FinalizacionGestacion::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    'cod_terminacion'       => $this->buscarTipoParto($row[159]),
                    'fec_evento'            => ($row[160] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[160]),
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
