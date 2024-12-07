<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\MortalidadPreparto;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportMortalidadPerinatal implements ToModel, WithStartRow
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
    private function buscarClasificacionMortalidad($antibio)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($antibio){
            case 'PERINATAL':
                return 1;
            case 'NEONATAL TEMPRANA':
                return 2;
            case 'NEONATAL TARDIA':
                return 3;
            case 'ABORTO (MENOR A 22 SEMANAS) ':
                return 4;
            case 'MORTALDIAD PERINATAL- DEJAR EN BLANCO.':
                return 6;
            case 'NO ES';
                return 5;
            default:
                return 5;
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
                MortalidadPreparto::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    'fec_defuncion'             => ($row[173] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[173]),
                    'cod_mortalidad'            => $this->buscarClasificacionMortalidad($row[174]),
                    
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
