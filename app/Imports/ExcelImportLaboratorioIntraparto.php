<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\LaboratorioIntraparto;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportLaboratorioIntraparto implements ToModel, WithStartRow
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
    private function buscarPruebaTreponemica($prueba)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($prueba){
            case 'NO REACTIVO':
                return 1;
            case '1:2':
                return 2;
            case '1:4':
                return 3;
            case '1:8':
                return 4;
            case '1:16':
                return 5;
            case '1:32':
                return 6;
            case '1:64':
                return 7;
            case '1:128':
                return 8;
            case '1:256':
                return 9;
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
                LaboratorioIntraparto::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    // nulos
                    'pru_sifilis'           => $row[161] ?? null,
                    'fec_sifilis'           => ($row[162] ?? '') == '' ? null : $this->convertirFecha($row[162]), 

                    'cod_vdrl'              => $this->buscarPruebaTreponemica($row[163]),
                    'fec_vdrl'              => ($row[164] ?? '') == '' ? null : $this->convertirFecha($row[164]),

                    'rec_sifilis'           => $row[165] ?? null,
                    'fec_tratamiento'       => ($row[166] ?? '') == '' ? null : $this->convertirFecha($row[166]),
        
                    'pru_vih'               => $row[167] ?? null,
                    'fec_vih'               => ($row[168] ?? '') == '' ? null : $this->convertirFecha($row[168]),
                    // nulos

                    'reali_prueb_trepo_rapi_sifilis_intra'      => ($row[161] ?? '') == '' ? false : true,
                    'reali_prueb_no_trepo_vdrl_sifilis_intra'   => ($row[163] ?? '') == '' ? false : true,
                    'reali_prueb_rapi_vih'                      => ($row[167] ?? '') == '' ? false : true,
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
