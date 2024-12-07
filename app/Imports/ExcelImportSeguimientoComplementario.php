<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\SeguimientoComplementario;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportSeguimientoComplementario implements ToModel, WithStartRow
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

    // funcion para buscar el dato de numero de sesiones para maternidad y paternidad (COLUMNA 155 o COLUMNA EY del EXCEL)
    private function buscarNumeroSesiones($sesion)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch ($sesion) {
            case '0':
                return 1;
            case '1':
                return 2;
            case '2':
                return 3;
            case '3':
                return 4;
            case '4':
                return 5;
            case '5':
                return 6;
            case '6':
                return 7;
            case '7':
                return 8;
            case '8':
                return 9;
            case '9':
                return 10;
            case '10':
                return 11;
            case '11':
                return 12;
            case '12':
                return 13;
            case '13':
                return 14;
            case '14':
                return 15;
            case '15':
                return 16;
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
                SeguimientoComplementario::create([
                    'id_operador'               => $this->operador,
                    'id_usuario'                => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'      => $idProcesoGestativo->id,

                    //nulos
                    'fec_nutricion'             => ($row[148] ?? '') == '' ? null : $this->convertirFecha($row[148]),
                    'fec_ginecologia'           => ($row[149] ?? '') == '' ? null : $this->convertirFecha($row[149]),
                    'fec_psicologia'            => ($row[150] ?? '') == '' ? null : $this->convertirFecha($row[150]),
                    'fec_odontologia'           => ($row[151] ?? '') == '' ? null : $this->convertirFecha($row[151]),
                    //nulos

                    'ina_seguimiento'           => $row[152] ?? 'No se encontro dato',

                    //nulos
                    'cau_inasistencia'          => $row[153] ?? null,
                    //nulos

                    'cod_sesiones'              => $this->buscarNumeroSesiones($row[154]),
        
                    'asistio_nutricionista'     => ($row[148] ?? '') == '' ? false : true,
                    'asistio_ginecologia'       => ($row[149] ?? '') == '' ? false : true,
                    'asistio_psicologia'        => ($row[150] ?? '') == '' ? false : true,
                    'asistio_odontologia'       => ($row[151] ?? '') == '' ? false : true,
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
