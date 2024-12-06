<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\Vacunacion;
use App\Models\Biologico;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportVacunacion implements ToModel, WithStartRow
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
    private function buscarBiologico($metodo)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($metodo){
            case 'SINOVAC':
                return 1;
            case 'JANSSEN':
                return 2;
            case 'ASTRAZENECA':
                return 3;
            case 'PFIZER':
                return 4;
            case 'MODERNA':
                return 5;
            default:
                return 1;
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
        // buscamos el codigo del proceso gestativo que tenga la gestante
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {
            // llamamos a la funcion que busca el id de claisificacion de riesgo
            $clasificacionRiesgo = $this->buscarBiologico($row[54]);

            try {
                Vacunacion::create([
                    'id_operador'       => $this->operador,
                    'id_usuario'        => $usuarioExistente->id_usuario,
                    'fec_unocovid'      => ($row[51] ?? '') == '' ? null : $this->convertirFecha($row[51]), // PUEDE NULL $row[51] ?? 'No se encontro'
                    'fec_doscovid'      => ($row[52] ?? '') == '' ? null : $this->convertirFecha($row[52]), // PUEDE NULL $row[52] ?? 'No se encontro'
                    'fec_refuerzo'      => ($row[53] ?? '') == '' ? null : $this->convertirFecha($row[53]), // PUEDE NULL $row[53] ?? 'No se encontro'
                    'cod_biologico'     => $clasificacionRiesgo,
                    'fec_influenza'     => ($row[55] ?? '') == '' ? null : $this->convertirFecha($row[55]), // PUEDE NULL $row[55] ?? 'No se encontro'
                    'fec_tetanico'      => ($row[56] ?? '') == '' ? null : $this->convertirFecha($row[56]), // PUEDE NULL $row[56] ?? 'No se encontro'
                    'fec_dpt'           => ($row[57] ?? '') == '' ? null : $this->convertirFecha($row[57]), // PUEDE NULL $row[57] ?? 'No se encontro'

                    'recib_prim_dosis_covid19'     => ($row[51] ?? '') == '' ? false : true,
                    'recib_segu_dosis_covid19'     => ($row[52] ?? '') == '' ? false : true, // 'No se encontro dato10'
                    'recib_refu_covid19'           => ($row[53] ?? '') == '' ? false : true, // 'No se encontro dato10'
                    'recib_dosis_influenza'        => ($row[55] ?? '') == '' ? false : true, // 'No se encontro dato10'
                    'recib_dosis_tox_tetanico'     => ($row[56] ?? '') == '' ? false : true, // 'No se encontro dato10'
                    'recib_dosis_dpt_a_celular'    => ($row[57] ?? '') == '' ? false : true, // 'No se encontro dato10'
                ]);
            } catch (\Exception $e) {
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
        //     'id_operador'                  => $this->operador,
        //     'id_usuario'                   => 'No se encontro dato1',
            
        //     'fec_unocovid'                 => $row[51] ?? 'No se encontro dato3',
        //     'fec_doscovid'                 => $row[52] ?? 'No se encontro dato4',
        //     'fec_refuerzo'                 => $row[53] ?? 'No se encontro dato5',
        //     'cod_biologico'                => $row[54] ?? 'No se encontro dato6',
        //     'fec_influenza'                => $row[55] ?? 'No se encontro dato6',
        //     'fec_tetanico'                 => $row[56] ?? 'No se encontro dato7',
        //     'fec_dpt'                      => $row[57] ?? 'No se encontro dato8',

        //     'recib_prim_dosis_covid19'     => 'No se encontro dato9',

        //     'recib_segu_dosis_covid19'     => 'No se encontro dato10',
        //     'recib_refu_covid19'           => 'No se encontro dato11', 
        //     'recib_dosis_influenza'        => 'No se encontro dato12',
        //     'recib_dosis_tox_tetanico'     => 'No se encontro dato13',              
        // ];