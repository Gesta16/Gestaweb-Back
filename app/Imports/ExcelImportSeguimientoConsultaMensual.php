<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\SeguimientoConsultaMensual;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportSeguimientoConsultaMensual implements ToModel, WithStartRow
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

    // funcion para tomar el numero de controles que tiene 
    private function buscarNumeroControl($antibio)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch ($antibio) {
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
            case '16':
                return 17;
            case '17':
                return 18;
            case '18':
                return 19;
            case '19':
                return 20;
            case '20':
                return 21;
            default:
                return 1;
        }
    }

    // funcion para tomar el dato de la clasificacion del riesgo
    private function buscarClasificacionRiesgo($riesgo)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($riesgo){
            case 'MUY ALTO':
                return 1;
            case 'ALTO':
                return 2;
            case 'MODERADO':
                return 3;
            case 'BAJO':
                return 4;
            default:
                return 4;
        }
    }

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarDiagnosticoNutricional($diagnostico)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($diagnostico){
            case 'IMC ADECUADO PARA EDAD GESTACIONAL':
                return 1;
            case 'BAJO PESO PARA EDAD GESTACIONAL':
                return 2;
            case 'SOBREPESO PARA EDAD GESTACIONAL':
                return 3;
            case 'OBESIDAD PARA EDAD GESTACIONAL':
                return 4;
            default:
                return 1;
        }
    }

    // funcion para tomar el dato del trimestre gestacional actual (COLUMNA 140 o COLUMNA EJ del EXCEL)
    private function buscarTrimestreGestacional($trimestre)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($trimestre){
            case 'I Trim':
                return 1;
            case 'II Trim':
                return 2;
            case 'III Trim':
                return 3;
            case 'Gest, Fin':
                return 4;
            default:
                return 4;
        }
    }

    // funcion para tomar el dato de forma de medicion de edad gestacional (COLUMNA 148 o COLUMNA ER del EXCEL)
    private function buscarFormaMedicionGestante($trimestre)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($trimestre){
            case '1- FUR CONFIABLE':
                return 1;
            case '2- FUR NO CONFIABLE':
                return 2;
            case '3- ECOGRAFIA':
                return 3;
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
                SeguimientoConsultaMensual::create([
                    'id_operador' => $this->operador,
                    'id_usuario' => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id' => $idProcesoGestativo->id,

                    'fec_consulta'          => ($row[135] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[135]),
                    'cod_controles'         => $this->buscarNumeroControl($row[136]),

                    'edad_gestacional'      => is_numeric($row[137] ?? null) ? $row[137] : 0,
                    'alt_uterina'           => is_numeric($row[138] ?? null) ? $row[138] : 0,

                    'trim_gestacional'      => $this->buscarTrimestreGestacional($row[139]),
                    'cod_riesgo'            => $this->buscarClasificacionRiesgo($row[140]),
                    'peso'                  => is_numeric($row[141] ?? null) ? $row[141] : 0,

                    'talla'                 => is_numeric($row[142] ?? null) ? $row[142] : 0,
                    'imc'                   => is_numeric($row[143] ?? null) ? $row[143] : 0,
                    'cod_diagnostico'       => $this->buscarDiagnosticoNutricional($row[144]),

                    'ten_arts'              => is_numeric($row[145] ?? null) ? $row[145] : 0,
                    'ten_artd'              => is_numeric($row[146] ?? null) ? $row[146] : 0,

                    'cod_medicion'          => $this->buscarFormaMedicionGestante($row[147]),

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
