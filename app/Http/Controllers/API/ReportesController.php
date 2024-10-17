<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function getUsuariosFiltrados(Request $request)
    {
        
        $edad = $request->input('edad'); // '<18', '18-28', '28-38', '>38'
        $estrato = $request->input('estrato'); // '1','2','3','4','>4'
        $regimen = $request->input('regimen'); // 'contributivo','subsidiado'
        $poblacionDiferencial = $request->input('poblacion_diferencial'); 
        $departamento = $request->input('departamento'); 
        $municipio = $request->input('municipio'); 
        $planeado = $request->input('planeado'); // 'si','no'
        $fracasoAnticonceptivo = $request->input('fracaso_anticonceptivo'); // 'si','no'
        $metodoFracaso = $request->input('metodo_fracaso'); 
        $nivelRiesgo = $request->input('nivel_riesgo'); 
        $nacimiento = $request->input('nacimiento'); // 'vivo','muerto'
        $prematuro = $request->input('prematuro'); // 'si','no'

        // Inicio de la consulta
        $query = Usuario::query();

        // Filtro por edad
        if ($edad) {
            switch ($edad) {
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
                default:
                    // Opcional: manejar caso por defecto o ignorar
                    break;
            }
        }

        // Filtro por estrato social
        if ($estrato) {
            if ($estrato === '>4') {
                $query->where('estrato_social', '>', 4);
            } else {
                $query->where('estrato_social', $estrato);
            }
        }

        // Filtro por régimen
        if ($regimen) {
            $query->whereHas('ips.regimen', function ($q) use ($regimen) {
                $q->where('nom_regimen', $regimen);
            });
        }

        // Filtro por población diferencial
        if ($poblacionDiferencial) {
            // Asumiendo que se puede filtrar por nombre o código
            $query->whereHas('poblacionDiferencial', function ($q) use ($poblacionDiferencial) {
                $q->where('nom_poblacion', $poblacionDiferencial)
                  ->orWhere('cod_poblacion', $poblacionDiferencial);
            });
        }

        // Filtro por departamento
        if ($departamento) {
            // Asumiendo que se puede filtrar por nombre o código
            $query->whereHas('departamento', function ($q) use ($departamento) {
                $q->where('nom_departamento', $departamento)
                  ->orWhere('cod_departamento', $departamento);
            });
        }

        // Filtro por municipio
        if ($municipio) {
            // Asumiendo que se puede filtrar por nombre o código
            $query->whereHas('municipio', function ($q) use ($municipio) {
                $q->where('nom_municipio', $municipio)
                  ->orWhere('cod_municipio', $municipio);
            });
        }

        // Filtro por factores de embarazo
        if ($planeado || $fracasoAnticonceptivo || $metodoFracaso || $nivelRiesgo) {
            $query->whereHas('controlesPrenatales', function ($q) use ($planeado, $fracasoAnticonceptivo, $metodoFracaso, $nivelRiesgo) {
                if ($planeado) {
                    $q->where('planeado', $planeado);
                }
                if ($fracasoAnticonceptivo) {
                    $q->where('fracaso_anticonceptivo', $fracasoAnticonceptivo);
                }
                if ($metodoFracaso) {
                    $q->whereHas('metodoFracaso', function ($q2) use ($metodoFracaso) {
                        $q2->where('nom_fracaso', $metodoFracaso)
                           ->orWhere('cod_fracaso', $metodoFracaso);
                    });
                }
                if ($nivelRiesgo) {
                    $q->whereHas('riesgo', function ($q3) use ($nivelRiesgo) {
                        $q3->where('nom_riesgo', $nivelRiesgo)
                           ->orWhere('cod_riesgo', $nivelRiesgo);
                    });
                }
            });
        }

        $query->whereHas('finalizacion_gestacion', function ($q) use ($nacimiento, $prematuro) {
            if ($nacimiento) {
                // Ajustar el campo a 'cod_terminacion' para verificar que no sea aborto, mortalidad perinatal o IVE
                $q->whereNotIn('cod_terminacion', [3, 4, 5]);
            }
            if ($prematuro) {
                // Ajustar la relación con 'mortalidad_perinatal' usando el campo correcto
                $q->whereHas('mortalidad_perinatal', function ($q2) {
                    $q2->whereIn('cod_mortalidad', [2,3,4]);
                })
                ->orWhereHas('datos_recien_nacido', function ($q3) {
                    $q3->whereNotNull('pla_canguro'); // Asegurando que estamos usando el nombre correcto 'pla_canguro' en lugar de 'plan_canguro'
                });
            }
        });
        
        

        // Obtener los resultados y retornarlos en formato JSON
        $usuarios = $query->with([
            'ips.regimen',
            'poblacionDiferencial',
            'departamento',
            'municipio',
            'controlesPrenatales.metodoFracaso',
            'controlesPrenatales.riesgo',
            'mortalidad',
        ])->get();

        return response()->json($usuarios);
    }
}
