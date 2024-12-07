<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\TamizacionNeonatal;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportTamizacionNeonatal implements ToModel, WithStartRow
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

    // funcion para tomar el dato del tipo de hemoclasificacion (SANGRE)
    private function buscarHemoclasificacion($hemocla)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($hemocla){
            case 'A+':
                return 1;
            case 'A-':
                return 2;
            case 'B+':
                return 3;
            case 'B-':
                return 4;
            case 'AB+':
                return 5;
            case 'AB-':
                return 6;
            case 'O+':
                return 7;
            case 'O-':
                return 8;
            default:
                return 8;
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
                TamizacionNeonatal::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    'cod_hemoclasifi'       => $this->buscarHemoclasificacion($row[182]),
                    'fec_tsh'               => ($row[183] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[183]),
                    'resul_tsh'             => $row[184] ?? 'No se encontro dato',

                    //nulo
                    'pruetreponemica'       => $row[185] ?? null,
                    'fec_pruetrepo'         => ($row[186] ?? '') == '' ? null : $this->convertirFecha($row[186]),
                    
                    'tamiza_aud'            => $row[187] ?? null,
                    'tamiza_cardi'          => $row[188] ?? null,
                    'tamiza_visual'         => $row[189] ?? null,
                    //nulo

                    'reali_prueb_trepo_recien_nacido'       => ($row[185] ?? '') == '' ? false : true,
                    'reali_tami_auditivo'                   => ($row[187] ?? '') == '' ? false : true,
                    'reali_tami_cardiopatia_congenita'      => ($row[188] ?? '') == '' ? false : true,
                    'reali_tami_visual'                     => ($row[189] ?? '') == '' ? false : true,
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
