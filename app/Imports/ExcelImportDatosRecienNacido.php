<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\DatosRecienNacido;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExcelImportDatosRecienNacido implements ToModel, WithStartRow
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

    // funcion para la insercion de los datos
    public function model(array $row)
    {
        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {

            // buscamos el codigo del proceso gestativo que tenga la gestante
            $idProcesoGestativo = ProcesoGestativo::where('id_usuario', $usuarioExistente->id_usuario)->first();

            try {
                DatosRecienNacido::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    'tip_embarazo'           => $row[175] ?? 'No se encontro dato',
                    'num_nacido'             => is_numeric($row[176] ?? null) ? $row[176] : 1,  
                    'sexo'                   => (isset($row[177]) && ($row[177] === 'M' || $row[177] === 'F')) ? $row[177] : 'No se encontro dato',
                    'peso'                   => is_numeric($row[178] ?? null) ? $row[178] : 1,
                    'talla'                  => is_numeric($row[179] ?? null) ? $row[179] : 1,
                    'pla_canguro'            => $row[180] ?? 'No se encontro dato',

                    //nulo
                    'ips_canguro'            => ($row[180] ?? 'NO') == 'NO' ? null : $row[181] ?? 'No se encontro dato',
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
