<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SuperAdminController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\IpsController;
use App\Http\Controllers\API\OperadorController;
use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\DepartamentoController;
use App\Http\Controllers\API\TipoDocumentoController;
use App\Http\Controllers\API\RegimenController;
use App\Http\Controllers\API\PoblacionDiferencialController;
use App\Http\Controllers\API\MetodoFracasoController;
use App\Http\Controllers\API\RiesgoController;
use App\Http\Controllers\API\TipoDmController;
use App\Http\Controllers\API\BiologicoController;
use App\Http\Controllers\API\HemoclasificacionController;
use App\Http\Controllers\API\AntibiogramaController;
use App\Http\Controllers\API\PruebaNoTreponemicaVDRLController;
use App\Http\Controllers\API\PruebaNoTreponemicaRPRController;
use App\Http\Controllers\API\NumeroControlesController;
use App\Http\Controllers\API\DiagnosticoNutricionalMesController;
use App\Http\Controllers\API\FormaMedicionEdadGestacionalController;
use App\Http\Controllers\API\NumSesionesCursoPaternidadMaternidadController;
use App\Http\Controllers\API\TerminacionGestacionController;
use App\Http\Controllers\API\MetodoAnticonceptivoController;
use App\Http\Controllers\API\MortalidadPerinatalController;
use App\Http\Controllers\API\PruebaNoTreponemicaRecienNacidoController;
use App\Http\Controllers\API\MunicipioController;
use App\Http\Controllers\API\ControlPrenatalController;
use App\Http\Controllers\API\PrimeraConsultaController;
use App\Http\Controllers\API\VacunacionController;
use App\Http\Controllers\API\FinalizacionGestacionController;
use App\Http\Controllers\API\LaboratorioInTrapartoController;
use App\Http\Controllers\API\SeguimientoGestantePostObstetricoController;
use App\Http\Controllers\API\LaboratorioITrimestreController;
use App\Http\Controllers\API\LaboratorioIITrimestreController;
use App\Http\Controllers\API\LaboratorioIIITrimestreController;
use App\Http\Controllers\API\ItsController;
use App\Http\Controllers\API\SeguimientoConsultaMensualController;
use App\Http\Controllers\API\SeguimientoComplementarioController;
use App\Http\Controllers\API\MicronutrienteController;
use App\Http\Controllers\API\MortalidadPrepartoController;
use App\Http\Controllers\API\DatosRecienNacidoController;
use App\Http\Controllers\API\EstudioHipotiroidismoCongenitoController;
use App\Http\Controllers\API\ReportesController;
use App\Http\Controllers\API\RutaPYMSController;
use App\Http\Controllers\Api\TamizacionNeonatalController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class,'login']);
});

//Route::middleware('auth:api')->group(function () {

    /* RUTAS DEL SUPERADMIN */

    Route::get("superadmin",[SuperAdminController::class, 'index']);
    Route::post("superadmin",[SuperAdminController::class, 'store']);
    Route::get("superadmin/{id}",[SuperAdminController::class, 'show']);
    Route::post("superadmin/{id}",[SuperAdminController::class, 'update']);
    Route::delete("superadmin/{id}",[SuperAdminController::class, 'destroy']);

    /** RUTAS DEL ADMIN */

    Route::get("admin",[AdminController::class, 'index']);
    Route::post("admin",[AdminController::class, 'store']);
    Route::get("admin/{id}",[AdminController::class, 'show']);
    Route::post("admin/{id}",[AdminController::class, 'update']);
    Route::delete("admin/{id}",[AdminController::class, 'destroy']);

    /** RUTAS DE LA IPS */

    Route::get("ips",[IpsController::class, 'index']);
    Route::post("ips",[IpsController::class , 'store']);
    Route::get("ips/{id}",[IpsController::class, 'show']);
    Route::post("ips/{id}",[IpsController::class, 'update']);
    Route::delete("ips/{id}",[IpsController::class, 'destroy']);

    /** RUTAS DEL USUARIO*/

    Route::get("usuario",[UsuarioController::class, 'index']);
    Route::post("usuario",[UsuarioController::class , 'store']);
    Route::get("usuario/{id}",[UsuarioController::class, 'show']);
    Route::post("usuario/{id}",[UsuarioController::class, 'update']);
    Route::delete("usuario/{id}",[UsuarioController::class, 'destroy']);

//});/** RUTAS DEL OPERADOR */

Route::get("operador",[OperadorController::class, 'index']);
Route::post("operador",[OperadorController::class,  'store']);
Route::get("operador/{id}",[OperadorController::class,  'show']);
Route::post("operador/{id}",[OperadorController::class,  'update']);
Route::delete("operador/{id}",[OperadorController::class,  'destroy']);

/** RUTAS DEL DEPARTAMENTO */

Route::get("departamento",[DepartamentoController::class, 'index']);
Route::get("departamento/{id}",[DepartamentoController::class, 'show']);

/** RUTAS DEL TIPO DOCUMENTO */

Route::get("documento",[TipoDocumentoController::class , 'index']);
Route::get("documento/{id}",[TipoDocumentoController::class, 'show']);

/** RUTAS DEL REGIMEN */

Route::get("regimen",[RegimenController::class , 'index']);
Route::get("regimen/{id}",[RegimenController::class, 'show']);

/** RUTAS DE POBLACION DIFERENCIAL */

Route::get("poblacion-diferencial",[PoblacionDiferencialController::class , 'index']);
Route::get("poblacion-diferencial/{id}",[PoblacionDiferencialController::class, 'show']);

/** RUTAS DEL METODO FRACASO */

Route::get("metodo-fracaso",[MetodoFracasoController::class , 'index']);
Route::get("metodo-fracaso/{id}",[MetodoFracasoController::class, 'show']);

/** RUTAS DEL RIESGO */

Route::get("riesgo",[RiesgoController::class , 'index']);
Route::get("riesgo/{id}",[RiesgoController::class, 'show']);

/** RUTAS DEL TIPO DM */

Route::get("tipo-dm",[TipoDmController::class , 'index']);
Route::get("tipo-dm/{id}",[TipoDmController::class, 'show']);

/** RUTAS DEL BIOLOGICO */

Route::get("biologico",[BiologicoController::class , 'index']);
Route::get("biologico/{id}",[BiologicoController::class, 'show']);

/** RUTAS DE LA HEMOCLASIFICACION */

Route::get("hemoclasificacion",[HemoclasificacionController::class , 'index']);
Route::get("hemoclasificacion/{id}",[HemoclasificacionController::class, 'show']);

/** RUTAS DEL ANTIBIOGRAMA */

Route::get("antibiograma",[AntibiogramaController::class , 'index']);
Route::get("antibiograma/{id}",[AntibiogramaController::class, 'show']);

/** RUTAS DE LA PRUEBA NO TREPONEMICA VDRL */

Route::get("prueba-no-treponemica-VDRL",[PruebaNoTreponemicaVDRLController::class , 'index']);
Route::get("prueba-no-treponemica-VDRL/{id}",[PruebaNoTreponemicaVDRLController::class, 'show']);

/** RUTAS DE LA PRUEBA NO TREPONEMICA RPR */

Route::get("prueba-no-treponemica-RPR",[PruebaNoTreponemicaRPRController::class , 'index']);
Route::get("prueba-no-treponemica-RPR/{id}",[PruebaNoTreponemicaRPRController::class, 'show']);

/** RUTAS DE NUMERO CONTROLES */

Route::get("numero-controles",[NumeroControlesController::class , 'index']);
Route::get("numero-controles/{id}",[NumeroControlesController::class, 'show']);

/** RUTAS DE DIAGNOSTICO NUTRICIONAL MES */

Route::get("diagnostico-nutricional-mes",[DiagnosticoNutricionalMesController::class , 'index']);
Route::get("diagnostico-nutricional-mes/{id}",[DiagnosticoNutricionalMesController::class, 'show']);

/** RUTAS DE FORMA MEDICION EDAD GESTACIONAL */

Route::get("forma-medicion-edad-gestacional",[FormaMedicionEdadGestacionalController::class , 'index']);
Route::get("forma-medicion-edad-gestacional/{id}",[FormaMedicionEdadGestacionalController::class, 'show']);

/** RUTAS DE SESIONES CURSO PATERNIDAD Y MATERNIDAD */

Route::get("sesiones-curso-paternidad-maternidad",[NumSesionesCursoPaternidadMaternidadController::class , 'index']);
Route::get("sesiones-curso-paternidad-maternidad/{id}",[NumSesionesCursoPaternidadMaternidadController::class, 'show']);

/** RUTAS DE TERMINACION GESTACION */

Route::get("terminacion-gestacion",[TerminacionGestacionController::class , 'index']);
Route::get("terminacion-gestacion/{id}",[TerminacionGestacionController::class, 'show']);

/** RUTAS DE METODO ANTICONCEPTIVO */

Route::get("metodo-anticonceptivo",[MetodoAnticonceptivoController::class , 'index']);
Route::get("metodo-anticonceptivo/{id}",[MetodoAnticonceptivoController::class, 'show']);

/** RUTAS DE MORTALIDAD PERINATAL */

Route::get("mortalidad-perinatal",[MortalidadPerinatalController::class , 'index']);
Route::get("mortalidad-perinatal/{id}",[MortalidadPerinatalController::class, 'show']);

/** RUTAS DE MORTALIDAD PERINATAL */

Route::get("prueba-no-treponemica-recien-nacido",[PruebaNoTreponemicaRecienNacidoController::class , 'index']);
Route::get("prueba-no-treponemica-recien-nacido/{id}",[PruebaNoTreponemicaRecienNacidoController::class, 'show']);

/** RUTAS DE MUNICIPIO */

Route::get("municipio/{cod_departamento}",[MunicipioController::class , 'index']);
Route::get("municipio-individual/{id}",[MunicipioController::class, 'show']);

/** RUTAS DEL CONTROL PRENATAL */

Route::get('/control-prenatal', [ControlPrenatalController::class, 'index']);
Route::get('/control-prenatal/{id_usuario}', [ControlPrenatalController::class, 'show']);
Route::post('/control-prenatal', [ControlPrenatalController::class, 'store']);
Route::POST('/control-prenatal/{cod_control}', [ControlPrenatalController::class, 'update']);
Route::delete('/control-prenatal/{cod_control}', [ControlPrenatalController::class, 'destroy']);

/** RUTAS DE LA PRIMERA CONSULTA */

Route::get("primera-consulta",[PrimeraConsultaController::class, 'index']);
Route::post("primera-consulta",[PrimeraConsultaController::class, 'store']);
Route::get("primera-consulta/{id}",[PrimeraConsultaController::class, 'show']);
Route::post("primera-consulta/{id}",[PrimeraConsultaController::class, 'update']);
Route::delete("primera-consulta/{id}",[PrimeraConsultaController::class, 'destroy']);

/** RUTAS DE LA VACUNACION */

Route::get("vacunacion",[VacunacionController::class, 'index']);
Route::post("vacunacion",[VacunacionController::class, 'store']);
Route::get("vacunacion/{id}",[VacunacionController::class, 'show']);
Route::post("vacunacion/{id}",[VacunacionController::class, 'update']);
Route::delete("vacunacion/{id}",[VacunacionController::class, 'destroy']);

/** RUTAS DE FINALIZACION DE LA GESTACION */

Route::get('/finalizacion-gestacion', [FinalizacionGestacionController::class, 'index']);
Route::post('/finalizacion-gestacion', [FinalizacionGestacionController::class, 'store']);
Route::get('/finalizacion-gestacion/{id}', [FinalizacionGestacionController::class, 'show']);
Route::post('/finalizacion-gestacion/{id}', [FinalizacionGestacionController::class, 'update']);
Route::delete('/finalizacion-gestacion/{id}', [FinalizacionGestacionController::class, 'destroy']);

/** RUTAS DE LABORATORIO INTRAPARTO */

Route::get('/laboratorio-intraparto', [LaboratorioInTrapartoController::class, 'index']);
Route::post('/laboratorio-intraparto', [LaboratorioInTrapartoController::class, 'store']);
Route::get('/laboratorio-intraparto/{id}', [LaboratorioInTrapartoController::class, 'show']);
Route::delete('/laboratorio-intraparto/{id}', [LaboratorioInTrapartoController::class, 'destroy']);

/** RUTAS DE SEGUIMIENTO GESTANTE POST OBSTETRICO */

Route::get('/seguimiento-post-obstetrico', [SeguimientoGestantePostObstetricoController::class, 'index']);
Route::post('/seguimiento-post-obstetrico', [SeguimientoGestantePostObstetricoController::class, 'store']);
Route::get('/seguimiento-post-obstetrico/{id}', [SeguimientoGestantePostObstetricoController::class, 'show']);
Route::delete('/seguimiento-post-obstetrico/{id}', [SeguimientoGestantePostObstetricoController::class, 'destroy']);

/** RUTAS DEL LABORATORIO-I-SEMESTRE*/

Route::get("laboratorio-primer-semestre",[LaboratorioITrimestreController::class, 'index']);
Route::post("laboratorio-primer-semestre",[LaboratorioITrimestreController::class, 'store']);
Route::get("laboratorio-primer-semestre/{id}",[LaboratorioITrimestreController::class, 'show']);
Route::post("laboratorio-primer-semestre/{id}",[LaboratorioITrimestreController::class, 'update']);
Route::delete("laboratorio-primer-semestre/{id}",[LaboratorioITrimestreController::class, 'destroy']);

/** RUTAS DEL LABORATORIO-II-SEMESTRE*/

Route::get("laboratorio-segundo-semestre",[LaboratorioIITrimestreController::class, 'index']);
Route::post("laboratorio-segundo-semestre",[LaboratorioIITrimestreController::class, 'store']);
Route::get("laboratorio-segundo-semestre/{id}",[LaboratorioIITrimestreController::class, 'show']);
Route::post("laboratorio-segundo-semestre/{id}",[LaboratorioIITrimestreController::class, 'update']);
Route::delete("laboratorio-segundo-semestre/{id}",[LaboratorioIITrimestreController::class, 'destroy']);

/** RUTAS DEL LABORATORIO-III-SEMESTRE*/

Route::get("laboratorio-tercer-semestre",[LaboratorioIIITrimestreController::class, 'index']);
Route::post("laboratorio-tercer-semestre",[LaboratorioIIITrimestreController::class, 'store']);
Route::get("laboratorio-tercer-semestre/{id}",[LaboratorioIIITrimestreController::class, 'show']);
Route::post("laboratorio-tercer-semestre/{id}",[LaboratorioIIITrimestreController::class, 'update']);
Route::delete("laboratorio-tercer-semestre/{id}",[LaboratorioIIITrimestreController::class, 'destroy']);

/** RUTAS ITS*/

Route::get("its",[ItsController::class, 'index']);
Route::post("its",[ItsController::class, 'store']);
Route::get("its/{id}",[ItsController::class, 'show']);
Route::post("its/{id}",[ItsController::class, 'update']);
Route::delete("its/{id}",[ItsController::class, 'destroy']);

/** RUTAS DE SEGUIMIENTO CONSULTA MENSUAL*/

Route::get('seguimiento-consulta-mensual', [SeguimientoConsultaMensualController::class, 'index']); 
Route::post('seguimiento-consulta-mensual', [SeguimientoConsultaMensualController::class, 'store']);
Route::get('seguimiento-consulta-mensual/{id}', [SeguimientoConsultaMensualController::class, 'show']); 
Route::post('seguimiento-consulta-mensual/{id}', [SeguimientoConsultaMensualController::class, 'update']); 
Route::delete('seguimiento-consulta-mensual/{id}', [SeguimientoConsultaMensualController::class, 'destroy']);

/** RUTAS DE SEGUIMIENTO COMPLEMENTARIOS */

Route::get('seguimientos-complementarios', [SeguimientoComplementarioController::class, 'index']); 
Route::post('seguimientos-complementarios', [SeguimientoComplementarioController::class, 'store']); 
Route::get('seguimientos-complementarios/{id}', [SeguimientoComplementarioController::class, 'show']);
Route::post('seguimientos-complementarios/{id}', [SeguimientoComplementarioController::class, 'update']);
Route::delete('seguimientos-complementarios/{id}', [SeguimientoComplementarioController::class, 'destroy']);

/** RUTAS DE MICRONUTRIENTES */

Route::get('micronutrientes', [MicronutrienteController::class, 'index']); 
Route::post('micronutrientes', [MicronutrienteController::class, 'store']); 
Route::get('micronutrientes/{id}', [MicronutrienteController::class, 'show']);
Route::post('micronutrientes/{id}', [MicronutrienteController::class, 'update']);
Route::delete('micronutrientes/{id}', [MicronutrienteController::class, 'destroy']);

/** RUTAS DE MORTALIDAD PREPARTO */

Route::get('mortalidad-preparto', [MortalidadPrepartoController::class, 'index']);
Route::post('mortalidad-preparto', [MortalidadPrepartoController::class, 'store']);
Route::get('mortalidad-preparto/{id}', [MortalidadPrepartoController::class, 'show']);
Route::delete('mortalidad-preparto/{id}', [MortalidadPrepartoController::class, 'destroy']);

/** RUTAS DE DATOS DEL RECIEN NACIDO */

Route::get('datos-recien-nacido', [DatosRecienNacidoController::class, 'index']);
Route::post('datos-recien-nacido', [DatosRecienNacidoController::class, 'store']);
Route::get('datos-recien-nacido/{id}', [DatosRecienNacidoController::class, 'show']);
Route::delete('datos-recien-nacido/{id}', [DatosRecienNacidoController::class, 'destroy']);

/** RUTAS DE ESTUDIO HIPOTIROIDISMO*/

Route::get('/estudios-hipotiroidismo', [EstudioHipotiroidismoCongenitoController::class, 'index']);
Route::post('/estudios-hipotiroidismo', [EstudioHipotiroidismoCongenitoController::class, 'store']);
Route::get('/estudios-hipotiroidismo/{id}', [EstudioHipotiroidismoCongenitoController::class, 'show']);
Route::delete('/estudios-hipotiroidismo/{id}', [EstudioHipotiroidismoCongenitoController::class, 'destroy']);

/** RUTAS DE RUTAS PYMS*/

Route::get('/rutas-pyms', [RutaPYMSController::class, 'index']);
Route::post('/rutas-pyms', [RutaPYMSController::class, 'store']);
Route::get('/rutas-pyms/{id}', [RutaPYMSController::class, 'show']);
Route::delete('/rutas-pyms/{id}', [RutaPYMSController::class, 'destroy']);

/** RUTAS DE RUTAS TAMIZACIONES NEONATALES*/

Route::get('/tamizaciones-neonatales', [TamizacionNeonatalController::class, 'index']);
Route::post('/tamizaciones-neonatales', [TamizacionNeonatalController::class, 'store']);
Route::get('/tamizaciones-neonatales/{id}', [TamizacionNeonatalController::class, 'show']);
Route::delete('/tamizaciones-neonatales/{id}', [TamizacionNeonatalController::class, 'destroy']);

/* RUTAS DE REPORTES */
Route::get('/usuarios-filtrados', [ReportesController::class, 'getUsuariosFiltrados']);
Route::post('/export-usuarios', [ReportesController::class, 'exportUsuariosFiltrados']);