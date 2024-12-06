<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\LaboratorioIIITrimestre;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportLaboratorio_3 implements ToModel, WithStartRow
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


            try {
                LaboratorioIIITrimestre::create([
                    'id_operador'               => $this->operador,
                    'id_usuario'                => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'      => $idProcesoGestativo->id,

                    'hemograma'                         => $row[114] ?? 'No se encontro dato',
                    'fec_hemograma'                     => ($row[115] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[115]),

                    //nulos
                    'pru_vih'                           => $row[116] ?? null,
                    'fec_vih'                           => ($row[117] ?? '') == '' ? null : $this->convertirFecha($row[117]),
                    //nulos

                    //nulos
                    'pru_sifilis'                       => $row[118] ?? null,
                    'fec_sifilis'                       => ($row[119] ?? '') == '' ? null : $this->convertirFecha($row[119]),
                    //nulos

                    //nulos
                    'ig_toxoplasma'                     => $row[120] ?? null,
                    'fec_toxoplasma'                    => ($row[121] ?? '') == '' ? null : $this->convertirFecha($row[121]),
                    //nulos
                    
                    //nulos
                    'cul_rectal'                        => $row[122] ?? null,
                    'fec_rectal'                        => ($row[123] ?? '') == '' ? null : $this->convertirFecha($row[123]),
                    //nulos

                    //nulos
                    'fec_biofisico'                     => ($row[124] ?? '') == '' ? null : $this->convertirFecha($row[124]),
                    'edad_gestacional'                  => is_numeric($row[125] ?? null) ? $row[125] : null,
                    //nulos

                    'rie_biopsicosocial'                => $row[126] ?? 'No se encontro dato',
                    'reali_prueb_rapi_vih_3'            => ($row[116] ?? '') == '' ? false : true,
                    'reali_prueb_trepo_rapi_sifilis'    => ($row[118] ?? '') == '' ? false : true,
                    'reali_prueb_igm_toxoplasma'        => ($row[120] ?? '') == '' ? false : true,
                    'reali_prueb_culti_rect_vagi'       => ($row[122] ?? '') == '' ? false : true,
                    'reali_prueb_perfil_biofisico'      => ($row[124] ?? '') == '' ? false : true,
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
