<?php

namespace App\Http\Controllers\API;

use App\Exports\ReporteExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    public function filtrarIndicadores(Request $request)
    {
        // Registrar los datos recibidos en la solicitud
        Log::info('Filtros recibidos:', $request->all());

        $categoria = $request->input('categoria');
        $subcategoria = $request->input('subcategoria');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $codDepartamento = $request->input('cod_departamento');
        $codMunicipio = $request->input('cod_municipio');
        $codPoblacion = $request->input('cod_poblacion');

        // Registrar cada filtro por separado
        Log::info('Categoría seleccionada:', ['categoria' => $categoria]);
        Log::info('Subcategoría seleccionada:', ['subcategoria' => $subcategoria]);
        Log::info('Fechas:', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
        Log::info('Ubicación:', ['cod_departamento' => $codDepartamento, 'cod_municipio' => $codMunicipio]);
        Log::info('Población diferencial:', ['cod_poblacion' => $codPoblacion]);

        // Mapeo de categorías y subcategorías
        $categorias = [
            'gestacion_saludable' => [
                'Micronutrientes' => ['tabla' => 'micronutrientes', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'aci_folico', 'sul_ferroso', 'car_calcio']],
                'Curso Prenatal' => ['tabla' => 'control_prenatal', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'fec_consulta', 'asis_consul_control_precon']],
                'Nutrición' => ['tabla' => 'seguimientos_complementarios', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'asistio_nutricionista', 'fec_nutricion']],
                'Salud Bucal' => ['tabla' => 'seguimientos_complementarios', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'asistio_odontologia',  'fec_odontologia']],
                'Ginecología' => ['tabla' => 'seguimientos_complementarios', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'asistio_ginecologia', 'fec_ginecologia']],
                'Psicología' => ['tabla' => 'seguimientos_complementarios', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'asistio_psicologia', 'fec_psicologia']],
            ],
            'parto_humanizado' => [
                'Cesáreas' => ['tabla' => 'partos', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'for_cesarea']],
            ],
            'planeacion_familiar' => [
                'Intención Reproductiva' => ['tabla' => 'control_prenatal', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'emb_planeado']],
                'Consulta IVE' => ['tabla' => 'control_prenatal', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'asis_asesoria_ive']],
            ],
            'gestantes_sin_riesgo' => [
                'Tratamiento de Sífilis' => ['tabla' => 'its', 'columnas' => ['usuario.nom_usuario', 'usuario.ape_usuario', 'usuario.documento_usuario', 'rec_tratamiento']],
            ],
        ];

        // Validar categoría y subcategoría
        if (!array_key_exists($categoria, $categorias) || !array_key_exists($subcategoria, $categorias[$categoria])) {
            Log::error('Categoría o subcategoría no válida', ['categoria' => $categoria, 'subcategoria' => $subcategoria]);
            return response()->json(['error' => 'Categoría o Subcategoría no válida'], 400);
        }

        // Obtener tabla y columnas
        $tabla = $categorias[$categoria][$subcategoria]['tabla'];
        $columnas = $categorias[$categoria][$subcategoria]['columnas'];
        Log::info('Tabla y columnas seleccionadas:', ['tabla' => $tabla, 'columnas' => $columnas]);

        // Construir consulta
        $query = DB::table($tabla)
            ->join('usuario', "$tabla.id_usuario", '=', 'usuario.id_usuario')
            ->select($columnas);

        // Aplicar filtros de fecha
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween("$tabla.fecha", [$fechaInicio, $fechaFin]);
            Log::info('Filtro de fechas aplicado', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
        }

        // Aplicar filtros de ubicación
        if ($codDepartamento) {
            $query->where('usuario.cod_departamento', $codDepartamento);
            Log::info('Filtro de departamento aplicado', ['cod_departamento' => $codDepartamento]);
        }
        if ($codMunicipio) {
            $query->where('usuario.cod_municipio', $codMunicipio);
            Log::info('Filtro de municipio aplicado', ['cod_municipio' => $codMunicipio]);
        }

        // Aplicar filtro de población diferencial
        if ($codPoblacion) {
            $query->where('usuario.cod_poblacion', $codPoblacion);
            Log::info('Filtro de población aplicado', ['cod_poblacion' => $codPoblacion]);
        }

        // Ejecutar consulta y capturar resultados
        try {
            $resultados = $query->get();
            Log::info('Resultados obtenidos', ['resultados' => $resultados]);
            Log::info('Generando archivo Excel...');
            return Excel::download(new ReporteExport($resultados), 'reporte.xlsx');
        } catch (\Exception $e) {
            Log::error('Error ejecutando la consulta', ['error' => $e->getMessage()]);
            Log::error('Error al generar el archivo Excel:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error al obtener los datos'], 500);
        }
    }
}
