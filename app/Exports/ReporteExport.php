<?php

namespace App\Exports;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteExport implements FromQuery, WithHeadings
{
    protected $request;
    protected $selectedFields;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->selectedFields = $this->getSelectedFields();
    }

    public function query()
    {
        // Aquí copiamos la lógica de tu consulta con los filtros
        $edad = $this->request->input('edad');
        $estrato = $this->request->input('estrato');
        $regimen = $this->request->input('regimen');
        $poblacionDiferencial = $this->request->input('poblacion_diferencial');
        $departamento = $this->request->input('departamento');
        $municipio = $this->request->input('municipio');
        $planeado = $this->request->input('planeado');
        $fracasoAnticonceptivo = $this->request->input('fracaso_anticonceptivo');
        $metodoFracaso = $this->request->input('metodo_fracaso');
        $nivelRiesgo = $this->request->input('nivel_riesgo');
        $nacimiento = $this->request->input('nacimiento');
        $prematuro = $this->request->input('prematuro');

        $query = Usuario::query();

        // Filtrar por edad
        if ($edad && count($edad) > 0) {
            switch ($edad[0]) { // Toma el primer valor del array para la evaluación
                case '<18':
                    $query->where('edad_usuario', '<', 18);
                    break;
                case '18-28':
                    $query->whereBetween('edad_usuario', [18, 28]);
                    break;
                case '28-38':
                    $query->whereBetween('edad_usuario', [28, 38]);
                    break;
                case '>38':
                    $query->where('edad_usuario', '>', 38);
                    break;
            }
        }

        // Filtrar por estrato social
        if ($estrato && count($estrato) > 0) {
            Log::info('Aplicando filtro por estrato:', ['estrato' => $estrato]);
            
            foreach ($estrato as $valorEstrato) {
                if ($valorEstrato === '>4') {
                    $query->where('estrato_social', '>', 4);
                } else {
                    // Agregamos un filtro específico para valores exactos de estrato
                    $query->orWhere('estrato_social', $valorEstrato);
                }
            }
        }

        // Filtrar por régimen
        if ($regimen && count($regimen) > 0) {
            $query->whereHas('ips.regimen', function ($q) use ($regimen) {
                $q->where('cod_regimen', $regimen[0]);
            });
        }

        // Filtrar por población diferencial
        if ($poblacionDiferencial && count($poblacionDiferencial) > 0) {
            $query->whereHas('poblacionDiferencial', function ($q) use ($poblacionDiferencial) {
                $q->where('nom_poblacion', $poblacionDiferencial[0])
                    ->orWhere('cod_poblacion', $poblacionDiferencial[0]);
            });
        }

        // Filtrar por departamento
        if ($departamento && count($departamento) > 0) {
            $query->whereHas('departamento', function ($q) use ($departamento) {
                $q->where('nom_departamento', $departamento[0])
                    ->orWhere('cod_departamento', $departamento[0]);
            });
        }

        // Filtrar por municipio
        if ($municipio && count($municipio) > 0) {
            $query->whereHas('municipio', function ($q) use ($municipio) {
                $q->where('nom_municipio', $municipio[0])
                    ->orWhere('cod_municipio', $municipio[0]);
            });
        }

        // Filtrar por factores de embarazo
        if ($planeado || $fracasoAnticonceptivo || $metodoFracaso || $nivelRiesgo) {
            $query->whereHas('controlesPrenatales', function ($q) use ($planeado, $fracasoAnticonceptivo, $metodoFracaso, $nivelRiesgo) {
                if ($planeado) {
                    $q->where('planeado', $planeado);
                }
                if ($fracasoAnticonceptivo) {
                    $q->where('fracaso_anticonceptivo', $fracasoAnticonceptivo);
                }
                if ($metodoFracaso && count($metodoFracaso) > 0) {
                    $q->whereHas('metodoFracaso', function ($q2) use ($metodoFracaso) {
                        $q2->where('nom_fracaso', $metodoFracaso[0])
                            ->orWhere('cod_fracaso', $metodoFracaso[0]);
                    });
                }
                if ($nivelRiesgo && count($nivelRiesgo) > 0) {
                    $q->whereHas('riesgo', function ($q3) use ($nivelRiesgo) {
                        $q3->where('nom_riesgo', $nivelRiesgo[0])
                            ->orWhere('cod_riesgo', $nivelRiesgo[0]);
                    });
                }
            });
        }

        // Filtrar por finalización de gestación
        if ($nacimiento || $prematuro) {
            $query->whereHas('finalizacion_gestacion', function ($q) use ($nacimiento, $prematuro) {
                if ($nacimiento) {
                    $q->whereNotIn('cod_terminacion', [3, 4, 5]);
                }
                if ($prematuro) {
                    $q->whereHas('mortalidad_perinatal', function ($q2) {
                        $q2->whereIn('cod_mortalidad', [2, 3, 4]);
                    })
                        ->orWhereHas('datos_recien_nacido', function ($q3) {
                            $q3->whereNotNull('pla_canguro');
                        });
                }
            });
        }

        $selectedColumns = [];

        if ($edad && count($edad) > 0) {
            $selectedColumns[] = 'edad_usuario';
        }

        if ($estrato && count($estrato) > 0) {
            $selectedColumns[] = 'estrato_social';
        }

        if ($regimen && count($regimen) > 0) {
            // Asumiendo que `regimen` es una columna que está presente directamente en el modelo `Usuario`
            $selectedColumns[] = 'regimen';
        }

        if (!empty($selectedColumns)) {
            $query->select($selectedColumns);
        }
    
        if (empty($selectedColumns)) {
            $selectedColumns[] = 'id';
        }
    

        $usuarios = $query->get();
        Log::info('Información de export', ['usuarios' => $usuarios]);
        return $usuarios;
    }



    public function headings(): array
    {
        $headings = [];

        foreach ($this->selectedFields as $field) {
            switch ($field) {
                case 'id':
                    $headings[] = 'ID';
                    break;
                case 'nombre':
                    $headings[] = 'Nombre';
                    break;
                case 'edad_usuario':
                    $headings[] = 'Edad';
                    break;
                case 'estrato_social':
                    $headings[] = 'Estrato Social';
                    break;
                case 'regimen':
                    $headings[] = 'Regimen';
                    break;
                case 'poblacion_diferencial':
                    $headings[] = 'Población Diferencial';
                    break;
                case 'departamento':
                    $headings[] = 'Departamento';
                    break;
                case 'municipio':
                    $headings[] = 'Municipio';
                    break;
                case 'planeado' || 'fracasoAnticonceptivo' || 'metodoFracaso' || 'nivelRiesgo':
                    $headings[] = 'Factores de Embarazo';
                    break;
                case 'nacimiento' || 'prematuro':
                    $headings[] = 'Finalización de Gestación';
                    break;
                default:
                    $headings[] = ucfirst(str_replace('_', ' ', $field));
            }
        }

        return $headings;
    }

    private function getSelectedFields(): array
    {
        $fields = ['id_usuario']; // Por defecto, siempre seleccionamos el ID

        if ($this->request->input('edad')) {
            $fields[] = 'edad_usuario';
        }

        if ($this->request->input('estrato')) {
            $fields[] = 'estrato_social';
        }

        if ($this->request->input('poblacionDiferencial')) {
            $fields[] = 'nom_poblacion';
        }

        if ($this->request->input('departamento')) {
            $fields[] = 'nom_departamento';
        }

        if ($this->request->input('municipio')) {
            $fields[] = 'nom_municipio';
        }

        if ($this->request->input('planeado') || $this->request->input('fracasoAnticonceptivo') || $this->request->input('metodoFracaso') || $this->request->input('nivelRiesgo')) {
            $fields[] = 'planeado';
            $fields[] = 'fracaso_anticonceptivo';
            $fields[] = 'metodoFracaso.nom_fracaso';
            $fields[] = 'riesgo.nom_riesgo';
        }

        if ($this->request->input('nacimiento') || $this->request->input('prematuro')) {
            $fields[] = 'finalizacion_gestacion.cod_terminacion';
            $fields[] = 'finalizacion_gestacion.pla_canguro';
        }



        return $fields;
    }
}
