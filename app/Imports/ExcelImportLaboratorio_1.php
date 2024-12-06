<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\ProcesoGestativo;
use App\Models\LaboratorioITrimestre;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImportLaboratorio_1 implements ToModel, WithStartRow
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

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarAntibiograma($antibio)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($antibio){
            case 'SENSIBLE A TODOS LOS ANTIBIOTICOS':
                return 1;
            case 'SENSIBLE A 5 ANTIBIOTICOS':
                return 2;
            case 'SENSIBLE A 4 ANTIBIOTICOS':
                return 3;
            case 'SENSIBLE A 3 ANTIBIOTICOS':
                return 4;
            case 'SENSIBLE A 2 ANTIBIOTICOS':
                return 5;
            case 'SENSIBLE A 1 ANTIBIOTICO':
                return 6;
            case 'RESISTENTE':
                return 7;
            default:
                return 1;
        }
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
            $hemoclasificacion = $this->buscarHemoclasificacion($row[58]);

            try {
                LaboratorioITrimestre::create([
                    'id_operador'                       => $this->operador,
                    'id_usuario'                        => $usuarioExistente->id_usuario,
                    'proceso_gestativo_id'              => $idProcesoGestativo->id,

                    'cod_hemoclasifi'                   => $hemoclasificacion,
                    'fec_hemoclasificacion'             => ($row[59] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[59]), // $row[59] ?? 'No se encontro dato'
                    'hem_laboratorio'                   => $row[60] ?? 'No se encontro dato',
                    'fec_hemograma'                     => ($row[61] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[61]), //  $row[61] ?? 'No se encontro dato'
                    'gli_laboratorio'                   => $row[62] ?? 999,
                    'fec_glicemia'                      => ($row[63] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[63]), // $row[63] ?? 'No se encontro dato'
        
                    'ant_laboratorio'                   => $row[64] ?? 'No se encontro dato',
                    'fec_antigeno'                      => ($row[65] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[65]),
                    'pru_vih'                           => $row[66] ?? null, // PUEDE NULL
        
                    'fec_vih'                           => ($row[67] ?? '') == '' ? null : $this->convertirFecha($row[67]), // PUEDE NULL
                    'pru_sifilis'                       => $row[68] ?? null, // PUEDE NULL
                    'fec_sifilis'                       => ($row[69] ?? '') == '' ? null : $this->convertirFecha($row[69]), // PUEDE NULL
        
                    'uro_laboratorio'                   => $row[70] ?? null, // PUEDE NULL
                    'fec_urocultivo'                    => ($row[71] ?? '') == '' ? null : $this->convertirFecha($row[71]), // PUEDE NULL
                    'cod_antibiograma'                  => ($row[72] ?? '') == '' ? null : $this->buscarAntibiograma($row[72]), // PUEDE NULL $row[72] ?? 'No se encontro dato'
                    'fec_antibiograma'                  => ($row[73] ?? '') == '' ? null : $this->convertirFecha($row[73]), // PUEDE NULL

                    'ig_rubeola'                        => $row[74]?? 'No se encontro dato',
                    'fec_rubeola'                       => ($row[75] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[75]),
                    'ig_toxoplasma'                     => $row[76]?? 'No se encontro dato',
                    
                    'fec_toxoplasma'                    => ($row[77] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[77]),
                    'hem_gruesa'                        => $row[80]?? 'No se encontro dato',
                    'fec_hemoparasito'                  => ($row[81] ?? '') == '' ? '1000-01-01' : $this->convertirFecha($row[81]),
                    
                    'pru_antigenos'                     => $row[82]?? null, // PUEDE NULL
                    'fec_antigenos'                     => ($row[83] ?? '') == '' ? null : $this->convertirFecha($row[83]), // PUEDE NULL
                    'eli_recombinante'                  => $row[84]?? null, // PUEDE NULL
                    
                    'fec_recombinante'                  => ($row[85] ?? '') == '' ? null : $this->convertirFecha($row[85]),// PUEDE NULL
                    'coo_cuantitativo'                  => $row[86] ?? null, // PUEDE NULL
                    'fec_coombs'                        => ($row[87] ?? '') == '' ? null : $this->convertirFecha($row[87]), // PUEDE NULL
                    
                    'fec_ecografia'                     => ($row[88] ?? '') == '' ? null : $this->convertirFecha($row[88]), // PUEDE NULL
                    'eda_gestacional'                   => is_numeric($row[89] ?? null) ? $row[89] : null, // PUEDE NULL
                    'rie_biopsicosocial'                => $row[90] ?? 'No se encontro dato',
                    
                    'real_prueb_rapi_vih'               => ($row[66] ?? '') == '' ? false : true,
                    'reali_prueb_trepo_rapid_sifilis'   => ($row[68] ?? '') == '' ? false : true,
                    'realizo_urocultivo'                => ($row[70] ?? '') == '' ? false : true,
                    
                    'realizo_antibiograma'              => ($row[72] ?? '') == '' ? false : true,
                    'real_prueb_eliza_anti_total'       => ($row[82] ?? '') == '' ? false : true,
                    'real_prueb_eliza_anti_recomb'      => ($row[84] ?? '') == '' ? false : true,
                    
                    'real_prueb_coombis_indi_cuanti'    => ($row[86] ?? '') == '' ? false : true,
                    'real_eco_obste_tamizaje'           => ($row[88] ?? '') == '' ? false : true,
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



