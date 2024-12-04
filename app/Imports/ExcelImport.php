<?php
namespace App\Imports;

use App\Models\Ips;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Usuario;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelImport implements ToModel, WithStartRow
{
    public $data = [];
    public $errorData = [];
    public $ipsData = [];
    public $departData = [];
    public $municData = [];
    private $ips;
    private $departamento;
    private $municipio;

    public function __construct() 
    {   
        // Cargar el mapeo de roles en memoria al inicializar la clase 
        $this->ips = Ips::pluck('cod_ips', 'nom_ips')->toArray();

        // Cargar el mapeo de roles en memoria al inicializar la clase 
        $this->departamento = Departamento::pluck('cod_departamento', 'nom_departamento')->toArray();

        // Cargar el mapeo de roles en memoria al inicializar la clase 
        $this->municipio = Municipio::pluck('cod_municipio', 'nom_municipio')->toArray();
    }

    // Especificar la fila de inicio
    public function startRow(): int
    {
        return 7;
    }

    // funcion para buscar la ips mas parecida al dato
    public function buscarIpsParecida($nombreBuscado)
    {   
        if($nombreBuscado == null){
            return null;
        }
        // Inicializar variables
        $similaridadMaxima = 0;
        $codIpsCoincidente = null;

        foreach ($this->ips as $nom_ips => $cod_ips) {

            // Calcular similitud
            similar_text(strtolower($nombreBuscado), strtolower($nom_ips), $porcentajeSimilitud);

            // Guardar la coincidencia más alta
            if ($porcentajeSimilitud > $similaridadMaxima) {
                $similaridadMaxima = $porcentajeSimilitud;
                $codIpsCoincidente = $cod_ips;
            }
            
        }

        // Verificar si la similitud cumple el umbral
        if ($similaridadMaxima >= 80) { // Porcentaje de parecido
            return $codIpsCoincidente;
        }

        // Retornar null si no hay coincidencia razonable
        return null;
    }

    // funcion para buscar la ips mas parecida al dato
    public function buscarDepartamentoParecido($nombreBuscado)
    {
        if($nombreBuscado == null){
            return null;
        }
        // Inicializar variables
        $similaridadMaxima = 0;
        $codIpsCoincidente = null;

        foreach ($this->departamento as $nom_departamento => $cod_departamento) {

            // Calcular similitud
            similar_text(strtolower($nombreBuscado), strtolower($nom_departamento), $porcentajeSimilitud);

            // Guardar la coincidencia más alta
            if ($porcentajeSimilitud > $similaridadMaxima) {
                $similaridadMaxima = $porcentajeSimilitud;
                $codIpsCoincidente = $cod_departamento;
            }
        }

        // Verificar si la similitud cumple el umbral
        if ($similaridadMaxima >= 70) { // Ajusta el umbral según tus necesidades
            return $codIpsCoincidente;
        }

        // Retornar null si no hay coincidencia razonable
        return null;
    }

    // funcion para buscar la ips mas parecida al dato
    public function buscarMunicipioParecido($nombreBuscado)
    {
        if($nombreBuscado == null){
            return null;
        }
        // Inicializar variables
        $similaridadMaxima = 0;
        $codIpsCoincidente = null;

        foreach ($this->municipio as $nom_municipio => $cod_municipio) {

            // Calcular similitud
            similar_text(strtolower($nombreBuscado), strtolower($nom_municipio), $porcentajeSimilitud);

            // Guardar la coincidencia más alta
            if ($porcentajeSimilitud > $similaridadMaxima) {
                $similaridadMaxima = $porcentajeSimilitud;
                $codIpsCoincidente = $cod_municipio;
            }
            
        }

        // Verificar si la similitud cumple el umbral
        if ($similaridadMaxima >= 70) { // Ajusta el umbral según tus necesidades
            return $codIpsCoincidente;
        }

        // Retornar null si no hay coincidencia razonable
        return null;
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

    // funcion para tomar el dato del tipo de documento que tiene la gestante
    private function buscarTipoDocumento($documento)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de documento
        switch($documento){
            case 'CC':
                return 1;
            case 'TI':
                return 7;
            case 'PT':
                return 9;
            case 'CE':
                return 2;
            case 'CD':
                return 3;
            case 'PA':
                return 4;
            case 'SC':
                return 5;
            case 'PE':
                return 6;
            case 'AS':
                return 8;
            default:
                return 8;
                
        }
    }

    // funcion para tomar el dato del tipo de poblacion que tiene la gestante
    private function buscarTipoPoblacion($poblacion)
    {
        // verificamos que trae la varaible y le asignamos un id de tipo de poblacion
        switch($poblacion){
            case 'Palenquero de San Basilio de Palenque':
                return 4;
            case 'Negro(a)':
                return 5;
            case 'Afrocolombiano(a)':
                return 6;
            case 'Población privada de la libertad':
                return 7;
            case 'LGTBI':
                return 8;
            case 'Victima del conflicto armado':
                return 9;
            case 'Migrante':
                return 10;
            case 'Ninguna de las anteriores':
                return 11;
            case 'Indígena':
                return 1;
            case 'ROM (Gitanos)':
                return 2;
            case 'Raizal (San Andrés y Providencia)':
                return 3;
            default:
                return 11;
        }
    }
    
        
    public function model(array $row)
    {

        // Verificar si ya existe el usuario con ese documento
        $usuarioExistente = Usuario::where('documento_usuario', $row[9])->first();

        if ($usuarioExistente) {
            // Si el usuario ya existe, registrar el error y continuar
            $this->errorData[] = [
                'documento' => $row[9],  // Documento duplicado
                'mensaje' => 'Usuario ya existe en la base de datos',  // Error de duplicado
            ];
            //$this->data[] = $errorData;
            
            // Asegurarse de que el proceso siga
            return null;
        }

        $ipsId = $this->buscarIpsParecida($row[2]);

        $departaId = $this->buscarDepartamentoParecido($row[4]);

        $municId = $this->buscarMunicipioParecido($row[5]);

        if ($ipsId == null) {
            $this->ipsData[] = [
                'documento' =>  $row[9] ?? 'no tiene documento',
                'ips' => $row[0],
                'mensaje' => 'No se encontro la IPS',
            ];
            //$this->data[] = $ipsData;

        } elseif($departaId == null) {
            $this->departData[] = [
                'depart' => $row[4],
                'mensaje' => 'No se encontro el Departamento',
            ];
            //$this->data[] = $deparData;
        } elseif($municId == null) {
            $this->municData[] = [
                'munic' => $row[5],
                'mensaje' => 'No se encontro el Municipio',
            ];
            //$this->data[] = $deparData;
        } else {
            try {

                $documento = $this->buscarTipoDocumento($row[8]);
                $poblacion = $this->buscarTipoPoblacion($row[15]);

                $fechaConv_diag_usuario = $this->convertirFecha($row[6]);
                $fechaConv_fec_ingreso = $this->convertirFecha($row[7]);
                $fechaConv_fec_nacim = $this->convertirFecha($row[14]);

                $emailUnico = 'N/A' . uniqid(mt_rand(), true);
                $teleUnico = 'N/E' . uniqid(mt_rand(), true);

                Usuario::create([
                    'cod_ips'           => $ipsId ?? null,
                    'cod_departamento'  => $departaId, // $row[4] ?? 'No se encontro dato'
                    'cod_municipio'     => $municId, // $row[5] ?? 'No se encontro dato'
                    'fec_diag_usuario'  => $fechaConv_diag_usuario,
                    'fec_ingreso'       => $fechaConv_fec_ingreso,
                    'cod_documento'     => $documento, // $row[8] ?? 'No se encontro dato'
                    'documento_usuario' => $row[9] ?? 'No se encontro dato',
                    'ape_usuario'       => ($row[10] ?? '') . ' ' . ($row[11] ?? ''),
                    'nom_usuario'       => ($row[12] ?? '') . ' ' . ($row[13] ?? ''),
                    'fec_nacimiento'    => $fechaConv_fec_nacim,
                    'cod_poblacion'     => $poblacion, // $row[15]
                    'edad_usuario'      => $row[16] ?? 'No se encontro dato',
                    'tel_usuario'       => ($row[17] ?? '') === 'NO REPORTA' ? $teleUnico : ($row[17] ?? $teleUnico),
                    'cel_usuario'       => $row[18] ?? 'No se encontro dato',
                    'dir_usuario'       => $row[19] ?? 'No se encontro dato',            
                    'email_usuario'     => $emailUnico,
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
// $this->data[] = [
        //     'cod_ips'           => $row[0] ?? null,
        //     'cod_departamento'  => $row[4] ?? 'No se encontro dato',
        //     'cod_municipio'     => $row[5] ?? 'No se encontro dato',
        //     'fec_diag_usuario'  => $this->convertirFecha($row[6]),
        //     'fec_ingreso'       => $this->convertirFecha($row[7]),
        //     'cod_documento'     => $row[8] ?? 'No se encontro dato',
        //     'documento_usuario' => $row[9] ?? 'No se encontro dato',
        //     'ape_usuario'       => ($row[10] ?? '') . ' ' . ($row[11] ?? ''),
        //     'nom_usuario'       => ($row[12] ?? '') . ' ' . ($row[13] ?? ''),
        //     'fec_nacimiento'    => $row[14] ?? 'No se encontro dato',
        //     'cod_poblacion'     => $row[15] ?? 'No se encontro dato',
        //     'edad_usuario'      => $row[16] ?? 'No se encontro dato',
        //     'tel_usuario'       => $row[17] ?? 'No se encontro dato',
        //     'cel_usuario'       => $row[18] ?? 'No se encontro dato',
        //     'dir_usuario'       => $row[19] ?? 'No se encontro dato',            
        //     'email_usuario'     => 'No esta presente en el excel',
        //     'num_proceso'       => 'No esta presente en el excel',
        // ];