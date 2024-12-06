<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\LaboratorioIITrimestre;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportLaboratorio_2 implements ToModel, WithStartRow
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

    // funcion para la insercion de los datos
    public function model(array $row)
    {
        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {

            // buscamos el codigo del proceso gestativo que tenga la gestante
            $idProcesoGestativo = ProcesoGestativo::where('id_usuario', $usuarioExistente->id_usuario)->first();

            // buscamos el codigo de hemoclasificacion
            //$hemoclasificacion = $this->buscarHemoclasificacion($row[58]);

            try {
                LaboratorioIITrimestre::create([
                    'id_operador'               => $this->operador,
                    'id_usuario'                => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'      => $idProcesoGestativo->id,

                    //nulos
                    'pru_vih'                   => $row[91] ?? null,
                    'fec_vih'                   => ($row[92] ?? '') == '' ? null : $this->convertirFecha($row[92]), // $row[59] ?? 'No se encontro dato'
                    'pru_sifilis'               => $row[93] ?? null,
                    'fec_sifilis'               => ($row[94] ?? '') == '' ? null : $this->convertirFecha($row[94]), //  $row[61] ?? 'No se encontro dato'
                    // nulos

                    'pru_oral'                  => $row[95] ?? 'No se encontro dato',
                    'pru_uno'                   => $row[96] ?? 'No se encontro dato', // $row[63] ?? 'No se encontro dato'
                    'pru_dos'                   => $row[97] ?? 'No se encontro dato',
                    'fec_prueba'                => ($row[98] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[98]),

                    //nulos
                    'rep_citologia'             => $row[99] ?? null, // PUEDE NULL
                    'fec_citologia'             => ($row[100] ?? '') == '' ? null : $this->convertirFecha($row[100]), // PUEDE NULL
                    // nulos

                    'ig_toxoplasma'             => $row[101] ?? 'No se encontro dato', // PUEDE NULL
                    'fec_toxoplasma'            => ($row[102] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[102]), // PUEDE NULL
                    
                    //nulos
                    'pru_avidez'                => $row[103] ?? null,
                    'fec_avidez'                => ($row[104] ?? '') == '' ? null : $this->convertirFecha($row[104]),
                    'tox_laboratorio'           => $row[105] ?? null, 
                    'fec_toxoplasmosis'         => ($row[106] ?? '') == '' ? null : $this->convertirFecha($row[106]),
                    'hem_gruesa'                => $row[107] ?? null,
                    'fec_hemoparasito'          => ($row[108] ?? '') == '' ? null : $this->convertirFecha($row[108]),
                    'coo_cualitativo'           => $row[109] ?? null,
                    'fec_coombs'                => ($row[110] ?? '') == '' ? null : $this->convertirFecha($row[110]),
                    'fec_ecografia'             => ($row[111] ?? '') == '' ? null : $this->convertirFecha($row[111]),
                    'eda_gestacional'           => is_numeric($row[112] ?? null) ? $row[112] : 999, // decimal
                    // nulos
                    
                    'rie_biopsicosocial'        => $row[113]?? 'No se encontro dato',
                    
                    
                    'reali_prueb_rapi_vih'              => ($row[91] ?? '') == '' ? false : true,
                    'real_prueb_trep_rap_sifilis'       => ($row[93] ?? '') == '' ? false : true,
                    'reali_citologia'                   => ($row[99] ?? '') == '' ? false : true,
                    'reali_prueb_avidez_ig_g'           => ($row[103] ?? '') == '' ? false : true,
                    'reali_prueb_toxoplasmosis_ig_a'    => ($row[105] ?? '') == '' ? false : true,
                    'reali_prueb_hemoparasito'          => ($row[107] ?? '') == '' ? false : true,
                    'reali_prueb_coombis_indi_cuanti'   => ($row[109] ?? '') == '' ? false : true,
                    'reali_eco_obste_detalle_anato'     => ($row[111] ?? '') == '' ? false : true,

                    'real_igm_toxoplasma'               => ($row[101] ?? '') == '' ? false : true,       
                    'real_prueb_oral'                   => ($row[95] ?? '') == '' ? false : true,
                    'real_prueb_oral_1'                 => ($row[96] ?? '') == '' ? false : true,
                    'real_prueb_oral_2'                 => ($row[97] ?? '') == '' ? false : true,
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
