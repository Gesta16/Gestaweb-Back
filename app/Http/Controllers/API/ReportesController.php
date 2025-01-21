<?php

namespace App\Http\Controllers\API;

use App\Exports\ReporteExport;
use App\Http\Controllers\Controller;
use App\Models\ControlPrenatal;
use App\Models\DatosRecienNacido;
use App\Models\FinalizacionGestacion;
use App\Models\Its;
use App\Models\LaboratorioIIITrimestre;
use App\Models\LaboratorioIITrimestre;
use App\Models\LaboratorioInTraparto;
use App\Models\LaboratorioITrimestre;
use App\Models\Micronutriente;
use App\Models\SeguimientoComplementario;
use App\Models\SeguimientoConsultaMensual;
use App\Models\SeguimientoGestantePostObstetrico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    public function filtrarIndicadores(Request $request)
    {
        // Registrar los datos recibidos en la solicitud
        Log::info('Filtros recibidos:', $request->all());

        // Validar que la subcategoría esté presente en la solicitud
        if (!$request->has('subcategoria') || empty($request->input('subcategoria'))) {
            Log::error('Subcategoría no seleccionada');
            return response()->json(['error' => 'La subcategoría es requerida'], 400);
        }

        $categoria = $request->input('categoria');
        $subcategoria = $request->input('subcategoria');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $codDepartamento = $request->input('cod_departamento');
        $codMunicipio = $request->input('cod_municipio');
        $codPoblacion = $request->input('cod_poblacion');
        $formato = $request->input('formato');

        // Registrar cada filtro por separado
        Log::info('Categoría seleccionada:', ['categoria' => $categoria]);
        Log::info('Subcategoría seleccionada:', ['subcategoria' => $subcategoria]);
        Log::info('Fechas:', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
        Log::info('Ubicación:', ['cod_departamento' => $codDepartamento, 'cod_municipio' => $codMunicipio]);
        Log::info('Población diferencial:', ['cod_poblacion' => $codPoblacion]);
        Log::info('formato escogido:', ['formato' => $formato]);



        // Mapeo de categorías y subcategorías
        $categorias = [
            'gestacion_saludable' => [
                'Micronutrientes' => [
                    'tabla' => 'micronutrientes',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'aci_folico' => 'Ácido Fólico',
                        'sul_ferroso' => 'Sulfato Ferroso',
                        'car_calcio' => 'Carbonato de Calcio'
                    ]
                ],
                'Curso Prenatal' => [
                    'tabla' => 'control_prenatal',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'fec_consulta' => 'Fecha Consulta',
                        'asis_consul_control_precon' => 'Asistio a control prenatal'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Nutrición' => [
                    'tabla' => 'seguimientos_complementarios',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asistio_nutricionista' => 'Asistió a nutricionista',
                        'fec_nutricion' => 'Fecha consulta nutrición'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Salud Bucal' => [
                    'tabla' => 'seguimientos_complementarios',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario'  => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asistio_odontologia' => 'Asistió a odontología',
                        'fec_odontologia' => 'Fecha consulta odontología'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Ginecología' => [
                    'tabla' => 'seguimientos_complementarios',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asistio_ginecologia' => 'Asistió a ginecología',
                        'fec_ginecologia' => 'Fecha consulta ginecología'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Psicología' => [
                    'tabla' => 'seguimientos_complementarios',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asistio_psicologia' => 'Asistió a psicología',
                        'fec_psicologia' => 'Fecha consulta psicología'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Lactancia' => [
                    'tabla' => 'primera_consulta',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asis_conse_lactancia' => 'Asistió a consejería lactancia',
                        'fec_lactancia' => 'Fecha consejería lactancia'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Elisa VIH' => [
                    'tabla' => 'its',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'reali_prueb_elisa_vih' => 'Realizo Prueba Elisa para VIH',
                        'eli_vih' => 'Resultado Elisa para VIH',
                        'fec_vih' => 'Fecha Elisa para VIH'
                    ],
                    'tipo_valores' => '0/1',
                ],
            ],
            'parto_humanizado' => [
                'Cesáreas' => [
                    'tabla' => 'primera_consulta',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'for_cesarea' => 'Cuantas cesareas'
                    ]
                ],
            ],
            'planeacion_familiar' => [
                'Intención Reproductiva' => [
                    'tabla' => 'control_prenatal',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'emb_planeado' => 'Embarazo planeado'
                    ],
                    'tipo_valores' => '0/1',
                ],
                'Consulta IVE' => [
                    'tabla' => 'control_prenatal',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'asis_asesoria_ive' => 'Assistio a asesoria IVE'
                    ],
                    'tipo_valores' => '0/1',
                ],
            ],
            'gestantes_sin_riesgo' => [
                'Tratamiento de Sífilis' => [
                    'tabla' => 'its',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'rec_tratamiento' => 'Recibio tratamiento'
                    ],
                    'tipo_valores' => 'Si/No',
                ],
            ],
            'puerperio_seguro' => [
                'Métodos Anticonceptivos' => [
                    'tabla' => 'seguimiento_gestante_post_obstetrico',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'cod_metodo' => 'Codigo metodo anticonceptivo',
                        'metodos_anticonceptivos.nom_metodo' => 'Metodo Anticonceptivo'
                    ]
                ],
                'Asesoría Anticonceptiva' => [
                    'tabla' => 'seguimiento_gestante_post_obstetrico',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'recib_aseso_anticonceptiva' => 'Recibio asesoria anticonceptiva'
                    ],
                    'tipo_valores' => '0/1',
                ]
            ],
            'neonatos_saludables' => [
                'Alta oportuna' => [
                    'tabla' => '_ruta__p_y_m_s',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'reali_entrega_carnet' => 'Entrega de carnet'
                    ],
                    'tipo_valores' => '0/1',
                ]
            ],
            'atencion_neonatal' => [
                'Tamizaje Hipotiroidismo' => [
                    'tabla' => 'estudio_hipotiroidismo_congenito',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'tsh' => 'TSH de seguimiento',
                        'fec_resultado' => 'Fecha resultado TSH',
                        't4_libre' => 'T4 Libre',
                        'fec_resultadot4' => 'Fecha resultado T4'
                    ]
                ],
                'Vacunación' => [
                    'tabla' => '_ruta__p_y_m_s',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'aplico_vacuna_bcg' => 'Se aplico vacuna BCG',
                        'fec_bcg' => 'Fecha de aplicación BCG',
                        'aplico_vacuna_hepatitis' => 'Se aplico vacuna hepatitis',
                        'fec_hepatitis' => 'Fecha de aplicación Hepatitis'
                    ]
                ],
                'Cardiopatías' => [
                    'tabla' => 'tamizacion_neonatal',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'reali_tami_cardiopatia_congenita' => 'Se realizo tamiza de cardiopatias congenitas',
                        'tamiza_cardi' => 'Resultado tamizaje'
                    ]
                ],
                'Tamizaje Auditivo' => [
                    'tabla' => 'tamizacion_neonatal',
                    'columnas' => [
                        'usuario.nom_usuario' => 'Nombre',
                        'usuario.ape_usuario' => 'Apellido',
                        'usuario.documento_usuario' => 'Documento',
                        'ips.nom_ips' => 'Ips',
                        'reali_tami_auditivo' => 'Se realizo tamizaje auditivo',
                        'tamiza_aud' => 'Resultado tamizaje auditivo'
                    ]
                ]
            ]
        ];

        // Validar categoría y subcategoría
        if (!array_key_exists($categoria, $categorias) || !array_key_exists($subcategoria, $categorias[$categoria])) {
            Log::error('Categoría o subcategoría no válida', ['categoria' => $categoria, 'subcategoria' => $subcategoria]);
            return response()->json(['error' => 'Categoría o Subcategoría no válida'], 400);
        }

        // Obtener tabla y columnas
        $tabla = $categorias[$categoria][$subcategoria]['tabla'];
        $columnas = $categorias[$categoria][$subcategoria]['columnas'];
        $columnKeys = array_keys($columnas); // Nombres reales de columnas
        $encabezados = array_values($columnas); // Títulos amigables para el Excel
        Log::info('Tabla y columnas seleccionadas:', ['tabla' => $tabla, 'columnas' => $columnas]);

        // Reconstruir columnKeys con prefijos explícitos y alias amigables
        $columnKeys = [];
        foreach ($columnas as $columna => $encabezado) {
            if (strpos($columna, '.') !== false) {
                // Si ya tiene un prefijo de tabla (como 'tabla.columna'), lo usamos directamente con alias
                $columnKeys[] = "$columna as $encabezado";
            } else {
                // Si no tiene prefijo, asumimos que pertenece a la tabla principal
                $columnKeys[] = "$tabla.$columna as $encabezado";
            }
        }
        Log::info('Columnas seleccionadas:', ['columnKeys' => $columnKeys]);

        // Construir consulta
        $query = DB::table($tabla)
            ->join('usuario', "$tabla.id_usuario", '=', 'usuario.id_usuario')
            ->leftjoin('ips', "usuario.cod_ips", '=', 'ips.cod_ips');

        // Verificar si la subcategoría es "Métodos Anticonceptivos"
        if ($subcategoria === 'Métodos Anticonceptivos') {
            $query->leftJoin('metodos_anticonceptivos', "$tabla.cod_metodo", '=', 'metodos_anticonceptivos.cod_metodo');
        }

        $query->select($columnKeys);

        // Obtener el tipo de valores para la subcategoría
        $tipoValores = $categorias[$categoria][$subcategoria]['tipo_valores'] ?? null;

        // Aplicar filtros dinámicos según el tipo de valores
        foreach ($columnKeys as $columnaAlias) {
            // Extraer solo la columna sin alias (antes de ' as ')
            $columnKey = explode(' as ', $columnaAlias)[0];

            // Verificar si la columna es booleana o necesita filtro
            if (in_array($columnKey, [
                "$tabla.aci_folico",
                "$tabla.sul_ferroso",
                "$tabla.car_calcio",
                "$tabla.asis_consul_control_precon",
                "$tabla.asistio_nutricionista",
                "$tabla.asistio_odontologia",
                "$tabla.asistio_ginecologia",
                "$tabla.asistio_psicologia",
                "$tabla.emb_planeado",
                "$tabla.asis_asesoria_ive",
                "$tabla.rec_tratamiento",
                "$tabla.asis_conse_lactancia",
                "$tabla.reali_prueb_elisa_vih"
            ])) {
                if ($tipoValores === 'Si/No') {
                    $query->where($columnKey, 'Si'); // Filtro para valores "Si" y "No"
                } elseif ($tipoValores === '0/1') {
                    $query->where($columnKey, 1); // Filtro para valores "0" y "1"
                }
                Log::info("Filtro aplicado para la columna $columnKey con valor $tipoValores");
            }
        }



        // Aplicar filtros de fecha
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween("$tabla.created_at", [$fechaInicio, $fechaFin]);
            Log::info('Filtro de fechas aplicado', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
        }

        // Aplicar filtros de ubicación
        if ($codDepartamento) {
            $encabezados[] = 'Departamento';
            $query->join('departamento', 'usuario.cod_departamento', '=', 'departamento.cod_departamento')
                ->where('usuario.cod_departamento', $codDepartamento)
                ->addSelect('departamento.nom_departamento as departamento_nombre'); // Seleccionar el nombre del departamento
            Log::info('Filtro de departamento aplicado', ['cod_departamento' => $codDepartamento]);
        }

        // Agregar join para poblaciones diferenciales si aplica el filtro de población
        if ($codPoblacion) {
            $encabezados[] = 'Población Diferencial';
            $query->join('poblacion_diferencial', 'usuario.cod_poblacion', '=', 'poblacion_diferencial.cod_poblacion')
                ->where('usuario.cod_poblacion', $codPoblacion)
                ->addSelect('poblacion_diferencial.nom_poblacion as poblacion_nombre'); // Seleccionar el nombre de la población
            Log::info('Filtro de población aplicado', ['cod_poblacion' => $codPoblacion]);
        }

        // Ejecutar consulta y capturar resultados
        try {
            $resultados = $query->get()->map(function ($item) {
                return (array) $item; // Convertir cada registro a un arreglo
            })->toArray();
            Log::info('Resultados obtenidos', ['resultados' => $resultados]);
            Log::info('Generando archivo Excel...');

            if($formato === 'pdf'){
                try {
                    $pdf = PDF::loadView('reportes.pdf', compact('resultados', 'encabezados'));
                    return $pdf->download('reporte.pdf');
                } catch (\Exception $e) {
                    Log::error('Error generando PDF', ['error' => $e->getMessage()]);
                    return response()->json(['error' => 'Error al generar el archivo PDF'], 500);
                }
            } else {
                return Excel::download(new ReporteExport($resultados, $encabezados), 'reporte.xlsx');
            }

            
        } catch (\Exception $e) {
            Log::error('Error ejecutando la consulta', ['error' => $e->getMessage()]);
            Log::error('Error al generar el archivo Excel:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al obtener los datos'], 500);
        }
    }


    public function obtenerRutaGestacional($idUsuario, $categoria, $subcategoria)
    {
        $data = [];

        if ($categoria === 'Control Prenatal') {
            $data = [
                'nombre' => 'Control Prenatal',
                'datos' => ControlPrenatal::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Laboratorios') {
            if ($subcategoria === 'Primer Trimestre') {
                $data = [
                    'nombre' => 'Laboratorios - Primer Trimestre',
                    'datos' => LaboratorioITrimestre::where('id_usuario', $idUsuario)->get(),
                ];
            } elseif ($subcategoria === 'Segundo Trimestre') {
                $data = [
                    'nombre' => 'Laboratorios - Segundo Trimestre',
                    'datos' => LaboratorioIITrimestre::where('id_usuario', $idUsuario)->get(),
                ];
            } elseif ($subcategoria === 'Tercer Trimestre') {
                $data = [
                    'nombre' => 'Laboratorios - Tercer Trimestre',
                    'datos' => LaboratorioIIITrimestre::where('id_usuario', $idUsuario)->get(),
                ];
            } elseif ($subcategoria === 'Its') {
                $data = [
                    'nombre' => 'Laboratorios - Its',
                    'datos' => Its::where('id_usuario', $idUsuario)->get(),
                ];
            } elseif ($subcategoria === 'Intraparto') {
                $data = [
                    'nombre' => 'Laboratorios - Intraparto',
                    'datos' => LaboratorioInTraparto::where('id_usuario', $idUsuario)->get(),
                ];
            }
        } elseif ($categoria === 'Seguimiento Mensual') {
            $data = [
                'nombre' => 'Seguimiento Mensual',
                'datos' => SeguimientoConsultaMensual::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Seguimiento Complementario') {
            $data = [
                'nombre' => 'Seguimiento Complementario',
                'datos' => Micronutriente::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Micronutrientes') {
            $data = [
                'nombre' => 'Micronutrientes',
                'datos' => SeguimientoComplementario::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Finalización de la Gestación') {
            $data = [
                'nombre' => 'Finalización de la Gestación',
                'datos' => FinalizacionGestacion::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Seguimiento Post Obstetrico') {
            $data = [
                'nombre' => 'Seguimiento Post Obstetrico',
                'datos' => SeguimientoGestantePostObstetrico::where('id_usuario', $idUsuario)->get(),
            ];
        } elseif ($categoria === 'Datos del Recién Nacido') {
            $data = [
                'nombre' => 'Datos del Recién Nacido',
                'datos' => DatosRecienNacido::where('id_usuario', $idUsuario)->get(),
            ];
        }

        return $data;
    }

    public function descargarRutaGestacionalPdf(Request $request, $idUsuario)
    {
        try {
            $categoria = $request->query('categoria');
            $subcategoria = $request->query('subcategoria');

            // Obtener los datos filtrados
            $data = $this->obtenerRutaGestacional($idUsuario, $categoria, $subcategoria);

            // Pasar el tipo de reporte a la vista
            $data['tipo_reporte'] = $data['nombre']; // Agregar el tipo de reporte

            // Logs para ver los datos obtenidos
            Log::info('Datos obtenidos para el PDF:', $data);

            // Verificar si hay datos
            if (empty($data) || (isset($data['datos']) && $data['datos']->isEmpty())) {
                Log::warning('No se encontraron datos para los filtros seleccionados.');
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron datos para los filtros seleccionados.',
                ], 404);
            }

            // Generar el PDF
            $pdf = Pdf::loadView('reportes.ruta_gestacional_pdf', ['data' => $data]);

            // Descargar el PDF
            return $pdf->download('ruta_gestacional.pdf');
        } catch (\Exception $e) {
            Log::error('Error al generar el PDF:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function generarReporteUnificado($id_usuario)
    {
        // Obtener datos para cada sección filtrados por id_usuario
        try {

            $data = [
                'id_usuario' => $id_usuario,
                'control_prenatal' => ControlPrenatal::where('id_usuario', $id_usuario)->get(),
                'laboratorios_primer_trimestre' => LaboratorioITrimestre::where('id_usuario', $id_usuario)->get(),
                'laboratorios_segundo_trimestre' => LaboratorioIITrimestre::where('id_usuario', $id_usuario)->get(),
                'laboratorios_tercer_trimestre' => LaboratorioIIITrimestre::where('id_usuario', $id_usuario)->get(),
                'laboratorios_its' => Its::where('id_usuario', $id_usuario)->get(),
                'seguimiento_mensual' => SeguimientoConsultaMensual::where('id_usuario', $id_usuario)->get(),
                'seguimiento_complementario' => SeguimientoComplementario::where('id_usuario', $id_usuario)->get(),
                'micronutrientes' => Micronutriente::where('id_usuario', $id_usuario)->get(),
                'laboratorios_intraparto' => LaboratorioInTraparto::where('id_usuario', $id_usuario)->get(),
                'seguimiento_post_obstetrico' => SeguimientoGestantePostObstetrico::where('id_usuario', $id_usuario)->get(),
                'finalizacion_gestacion' => FinalizacionGestacion::where('id_usuario', $id_usuario)->get(),
                'datos_recien_nacido' => DatosRecienNacido::where('id_usuario', $id_usuario)->get(),
            ];
            // Generar el PDF usando la vista 'reportes.reporte_unificado'
            $pdf = PDF::loadView('reportes.reporte_unificado', $data);
            Log::info('Datos obtenidos para el PDF:', $data);
            return $pdf->download("reporte_unificado_{$id_usuario}.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
