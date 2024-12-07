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
use App\Http\Controllers\API\RutaPYMSController;
use App\Http\Controllers\API\TamizacionNeonatalController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DashboardGestanteController;
use App\Http\Controllers\API\ReportesController;
use App\Http\Controllers\API\UserNoteController;
use App\Http\Controllers\API\ExcelController;

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
    Route::post('login', [AuthController::class, 'login']);
});


/* RUTAS DEL SUPERADMIN */
Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::apiResource("superadmin", SuperAdminController::class);
});

/** RUTAS DEL ADMIN */
Route::middleware(['auth:api', 'role:admin,superadmin'])->group(function () {
    Route::apiResource("admin", AdminController::class);
});

/** RUTAS DE LA IPS */
Route::middleware(['auth:api', 'role:superadmin,admin,operador,usuario'])->group(function () {
    Route::apiResource("ips", IpsController::class);
});

/** RUTAS DEL USUARIO*/
Route::middleware(['auth:api', 'role:superadmin,admin,operador,usuario'])->group(function () {
    Route::post("usuario/nuevo-proceso/{usuarioId}", [UsuarioController::class, 'crearProcesoGestativo']);
    Route::get("usuario/contar-procesos/{usuarioId}", [UsuarioController::class, 'contarProcesosGestativos']);
    Route::get('/usuario/{id_usuario}/completo', [UsuarioController::class, 'getUsuarioCompleto']);
    Route::post('/usuario/{id}', [UsuarioController::class, 'update']);
    Route::apiResource("usuario", UsuarioController::class);
});

//});/** RUTAS DEL OPERADOR */
Route::middleware(["auth:api", "role:superadmin,admin,operador"])->group(function () {
    Route::apiResource("operador", OperadorController::class);
});

/** RUTAS DEL DEPARTAMENTO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("departamento", DepartamentoController::class);
});

/** RUTAS DEL TIPO DOCUMENTO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("documento", TipoDocumentoController::class);
});

/** RUTAS DEL REGIMEN */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("regimen", RegimenController::class);
});

/** RUTAS DE POBLACION DIFERENCIAL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("poblacion-diferencial", PoblacionDiferencialController::class);
});

/** RUTAS DEL METODO FRACASO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("metodo-fracaso", MetodoFracasoController::class);
});

/** RUTAS DEL RIESGO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("riesgo", RiesgoController::class);
});

/** RUTAS DEL TIPO DM */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("tipo-dm", TipoDmController::class);
});

/** RUTAS DEL BIOLOGICO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("biologico", BiologicoController::class);
});

/** RUTAS DE LA HEMOCLASIFICACION */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("hemoclasificacion", HemoclasificacionController::class);
});

/** RUTAS DEL ANTIBIOGRAMA */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("antibiograma", AntibiogramaController::class);
});

/** RUTAS DE LA PRUEBA NO TREPONEMICA VDRL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    route::apiResource("prueba-no-treponemica-VDRL", PruebaNoTreponemicaVDRLController::class);
});

/** RUTAS DE LA PRUEBA NO TREPONEMICA RPR */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("prueba-no-treponemica-RPR", PruebaNoTreponemicaRPRController::class);
});

/** RUTAS DE NUMERO CONTROLES */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("numero-controles", NumeroControlesController::class);
});

/** RUTAS DE DIAGNOSTICO NUTRICIONAL MES */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("diagnostico-nutricional-mes", DiagnosticoNutricionalMesController::class);
});

/** RUTAS DE FORMA MEDICION EDAD GESTACIONAL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("forma-medicion-edad-gestacional", FormaMedicionEdadGestacionalController::class);
});

/** RUTAS DE SESIONES CURSO PATERNIDAD Y MATERNIDAD */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("sesiones-cpm", NumSesionesCursoPaternidadMaternidadController::class);
});

/** RUTAS DE TERMINACION GESTACION */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("terminacion-gestacion", TerminacionGestacionController::class);
});

/** RUTAS DE METODO ANTICONCEPTIVO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("metodo-anticonceptivo", MetodoAnticonceptivoController::class);
});

/** RUTAS DE MORTALIDAD PERINATAL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("mortalidad-perinatal", MortalidadPerinatalController::class);
});

/** RUTAS DE MORTALIDAD PERINATAL */ //PENDIENTE DE REVISAR SI SE ESTA UTILIZANDO
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::apiResource("prueba-ptrn", PruebaNoTreponemicaRecienNacidoController::class);
});

/** RUTAS DE MUNICIPIO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function () {
    Route::get("municipio/{cod_departamento}", [MunicipioController::class, 'index']);
    Route::get("municipio-individual/{id}", [MunicipioController::class, 'show']);
});


/** RUTAS DEL CONTROL PRENATAL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/control-prenatal', [ControlPrenatalController::class, 'index']);
    Route::get('/control-prenatal/{id_usuario}/{num_proceso}', [ControlPrenatalController::class, 'show']);
    Route::post('/control-prenatal', [ControlPrenatalController::class, 'store']);
    Route::post('/control-prenatal/{cod_control}', [ControlPrenatalController::class, 'update']);
    Route::delete('/control-prenatal/{cod_control}', [ControlPrenatalController::class, 'destroy']);
});

/** RUTAS DE LA PRIMERA CONSULTA */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get("primera-consulta", [PrimeraConsultaController::class, 'index']);
    Route::post("primera-consulta", [PrimeraConsultaController::class, 'store']);
    Route::get("primera-consulta/{id}/{num_proceso}", [PrimeraConsultaController::class, 'show']);
    Route::post("primera-consulta/{id}", [PrimeraConsultaController::class, 'update']);
    Route::delete("primera-consulta/{id}", [PrimeraConsultaController::class, 'destroy']);
});

/** RUTAS DE LA VACUNACION */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::apiResource("vacunacion", VacunacionController::class);
});

/** RUTAS DE FINALIZACION DE LA GESTACION */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/finalizacion-gestacion', [FinalizacionGestacionController::class, 'index']);
    Route::post('/finalizacion-gestacion', [FinalizacionGestacionController::class, 'store']);
    Route::get('/finalizacion-gestacion/{id}/{num_proceso}', [FinalizacionGestacionController::class, 'show']);
    Route::post('/finalizacion-gestacion/{id}', [FinalizacionGestacionController::class, 'update']);
    Route::delete('/finalizacion-gestacion/{id}', [FinalizacionGestacionController::class, 'destroy']);
});

/** RUTAS DE LABORATORIO INTRAPARTO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/laboratorio-intraparto', [LaboratorioInTrapartoController::class, 'index']);
    Route::post('/laboratorio-intraparto', [LaboratorioInTrapartoController::class, 'store']);
    Route::get('/laboratorio-intraparto/{id}/{num_proceso}', [LaboratorioInTrapartoController::class, 'show']);
    Route::post('/laboratorio-intraparto/{id}', [LaboratorioInTrapartoController::class, 'update']);
    Route::delete('/laboratorio-intraparto/{id}', [LaboratorioInTrapartoController::class, 'destroy']);
});

/** RUTAS DE SEGUIMIENTO GESTANTE POST OBSTETRICO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/seguimiento-post-obstetrico', [SeguimientoGestantePostObstetricoController::class, 'index']);
    Route::post('/seguimiento-post-obstetrico', [SeguimientoGestantePostObstetricoController::class, 'store']);
    Route::get('/seguimiento-post-obstetrico/{id}/{num_proceso}', [SeguimientoGestantePostObstetricoController::class, 'show']);
    Route::post('/seguimiento-post-obstetrico/{id}', [SeguimientoGestantePostObstetricoController::class, 'update']);
    Route::delete('/seguimiento-post-obstetrico/{id}', [SeguimientoGestantePostObstetricoController::class, 'destroy']);
});

/** RUTAS DEL LABORATORIO-I-SEMESTRE*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get("laboratorio-primer-semestre", [LaboratorioITrimestreController::class, 'index']);
    Route::post("laboratorio-primer-semestre", [LaboratorioITrimestreController::class, 'store']);
    Route::get("laboratorio-primer-semestre/{id}/{num_proceso}", [LaboratorioITrimestreController::class, 'show']);
    Route::post("laboratorio-primer-semestre/{id}", [LaboratorioITrimestreController::class, 'update']);
    Route::delete("laboratorio-primer-semestre/{id}", [LaboratorioITrimestreController::class, 'destroy']);
});

/** RUTAS DEL LABORATORIO-II-SEMESTRE*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get("laboratorio-segundo-semestre", [LaboratorioIITrimestreController::class, 'index']);
    Route::post("laboratorio-segundo-semestre", [LaboratorioIITrimestreController::class, 'store']);
    Route::get("laboratorio-segundo-semestre/{id}/{num_proceso}", [LaboratorioIITrimestreController::class, 'show']);
    Route::post("laboratorio-segundo-semestre/{id}", [LaboratorioIITrimestreController::class, 'update']);
    Route::delete("laboratorio-segundo-semestre/{id}", [LaboratorioIITrimestreController::class, 'destroy']);
});

/** RUTAS DEL LABORATORIO-III-SEMESTRE*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get("laboratorio-tercer-semestre", [LaboratorioIIITrimestreController::class, 'index']);
    Route::post("laboratorio-tercer-semestre", [LaboratorioIIITrimestreController::class, 'store']);
    Route::get("laboratorio-tercer-semestre/{id}/{num_proceso}", [LaboratorioIIITrimestreController::class, 'show']);
    Route::post("laboratorio-tercer-semestre/{id}", [LaboratorioIIITrimestreController::class, 'update']);
    Route::delete("laboratorio-tercer-semestre/{id}", [LaboratorioIIITrimestreController::class, 'destroy']);
});

/** RUTAS ITS*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get("its", [ItsController::class, 'index']);
    Route::post("its", [ItsController::class, 'store']);
    Route::get("its/{id}/{num_proceso}", [ItsController::class, 'show']);
    Route::post("its/{id}", [ItsController::class, 'update']);
    Route::delete("its/{id}", [ItsController::class, 'destroy']);
});

/** RUTAS DE SEGUIMIENTO CONSULTA MENSUAL*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('seguimiento-consulta-mensual', [SeguimientoConsultaMensualController::class, 'index']);
    Route::post('seguimiento-consulta-mensual', [SeguimientoConsultaMensualController::class, 'store']);
    Route::get('seguimiento-consulta-mensual/{id}/{num_proceso}', [SeguimientoConsultaMensualController::class, 'show']);
    Route::post('seguimiento-consulta-mensual/{id}', [SeguimientoConsultaMensualController::class, 'update']);
    Route::delete('seguimiento-consulta-mensual/{id}', [SeguimientoConsultaMensualController::class, 'destroy']);
    Route::get('/seguimientos-mensuales', [SeguimientoConsultaMensualController::class, 'seguimientosMensualesGestante']);

});

/** RUTAS DE SEGUIMIENTO COMPLEMENTARIOS */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('seguimientos-complementarios', [SeguimientoComplementarioController::class, 'index']);
    Route::post('seguimientos-complementarios', [SeguimientoComplementarioController::class, 'store']);
    Route::get('seguimientos-complementarios/{id}/{num_proceso}', [SeguimientoComplementarioController::class, 'show']);
    Route::post('seguimientos-complementarios/{id}', [SeguimientoComplementarioController::class, 'update']);
    Route::delete('seguimientos-complementarios/{id}', [SeguimientoComplementarioController::class, 'destroy']);
});

/** RUTAS DE MICRONUTRIENTES */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('micronutrientes', [MicronutrienteController::class, 'index']);
    Route::post('micronutrientes', [MicronutrienteController::class, 'store']);
    Route::get('micronutrientes/{id}/{num_proceso}', [MicronutrienteController::class, 'show']);
    Route::post('micronutrientes/{id}', [MicronutrienteController::class, 'update']);
    Route::delete('micronutrientes/{id}', [MicronutrienteController::class, 'destroy']);
});

/** RUTAS DE MORTALIDAD PREPARTO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('mortalidad-preparto', [MortalidadPrepartoController::class, 'index']);
    Route::post('mortalidad-preparto', [MortalidadPrepartoController::class, 'store']);
    Route::get('mortalidad-preparto/{id}/{num_proceso}', [MortalidadPrepartoController::class, 'show']);
    Route::post('mortalidad-preparto/{id}', [MortalidadPrepartoController::class, 'update']);
    Route::delete('mortalidad-preparto/{id}', [MortalidadPrepartoController::class, 'destroy']);
});

/** RUTAS DE DATOS DEL RECIEN NACIDO */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('datos-recien-nacido', [DatosRecienNacidoController::class, 'index']);
    Route::post('datos-recien-nacido', [DatosRecienNacidoController::class, 'store']);
    Route::get('datos-recien-nacido/{id}/{num_proceso}', [DatosRecienNacidoController::class, 'show']);
    Route::post('datos-recien-nacido/{id}', [DatosRecienNacidoController::class, 'update']);
    Route::delete('datos-recien-nacido/{id}', [DatosRecienNacidoController::class, 'destroy']);
});

/** RUTAS DE ESTUDIO HIPOTIROIDISMO*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/estudios-hipotiroidismo', [EstudioHipotiroidismoCongenitoController::class, 'index']);
    Route::post('/estudios-hipotiroidismo', [EstudioHipotiroidismoCongenitoController::class, 'store']);
    Route::get('/estudios-hipotiroidismo/{id}/{num_proceso}', [EstudioHipotiroidismoCongenitoController::class, 'show']);
    Route::post('/estudios-hipotiroidismo/{id}', [EstudioHipotiroidismoCongenitoController::class, 'update']);
    Route::delete('/estudios-hipotiroidismo/{id}', [EstudioHipotiroidismoCongenitoController::class, 'destroy']);
});

/** RUTAS DE RUTAS PYMS*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/rutas-pyms', [RutaPYMSController::class, 'index']);
    Route::post('/rutas-pyms', [RutaPYMSController::class, 'store']);
    Route::get('/rutas-pyms/{id}/{num_proceso}', [RutaPYMSController::class, 'show']);
    Route::post('/rutas-pyms/{id}', [RutaPYMSController::class, 'update']);
    Route::delete('/rutas-pyms/{id}', [RutaPYMSController::class, 'destroy']);
});

/** RUTAS DE RUTAS TAMIZACIONES NEONATALES*/
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/tamizaciones-neonatales', [TamizacionNeonatalController::class, 'index']);
    Route::post('/tamizaciones-neonatales', [TamizacionNeonatalController::class, 'store']);
    Route::get('/tamizaciones-neonatales/{id}/{num_proceso}', [TamizacionNeonatalController::class, 'show']);
    Route::post('/tamizaciones-neonatales/{id}', [TamizacionNeonatalController::class, 'update']);
    Route::delete('/tamizaciones-neonatales/{id}', [TamizacionNeonatalController::class, 'destroy']);
});

/** RUTAS DASHBOARD */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    Route::get('/calendario-usuario', [DashboardController::class, 'CalendarioUsuario']);
    Route::get('/conteo', [DashboardController::class, 'contarRegistros']);
    Route::get('/usuario-ips', [DashboardController::class, 'conteoUsuariosPorIps']);
    Route::get('/tamizaje-sifilis',[DashboardController::class, 'getProporcionTamizajeSifilis']);
    Route::get('/seguimientos-comple',[DashboardController::class, 'getCoverageData']);
    Route::get('/mortalidad-neonatalTemp',[DashboardController::class, 'getNeonatalMortalityRate']);
    Route::get('/consultas-ive',[DashboardController::class, 'getIveProportion']);
});

/** RUTAS REPORTES */
Route::post('/filtrar-indicadores', [ReportesController::class, 'filtrarIndicadores']);

/** RUTAS IMPORTACIÓN EXCEL */
Route::middleware(["auth:api", "role:superadmin,admin,operador,usuario"])->group(function(){
    
});
Route::post('/importar-excel', [ExcelController::class, 'procesarExcel']);

/** RUTAS USER NOTES */
Route::middleware(["auth:api", "role:usuario"])->group(function() {
    Route::get('/user-notes', [UserNoteController::class, 'index']);
    Route::get('/user-notes/{id}', [UserNoteController::class, 'show']);
    Route::post('/user-notes', [UserNoteController::class, 'store']);
    Route::put('/user-notes/{id}', [UserNoteController::class, 'update']);
    Route::delete('/user-notes/{id}', [UserNoteController::class, 'destroy']);
});


/* RUTAS DASHBOARD GESTANTE*/
Route::middleware(["auth:api", "role:usuario"])->group(function(){
    Route::get('/edadGestante', [DashboardGestanteController::class, 'getEdadGestacional']);
    Route::get('/conteoControles', [DashboardGestanteController::class, 'getControlesPrenatales']);
    Route::get('/sessionesCurso',[DashboardGestanteController::class, 'getSesionesCurso']);
    Route::get('/fechaProbParto', [DashboardGestanteController::class, 'getFechaProbableParto']);
    Route::get('/pesoYPresionGestante', [DashboardGestanteController::class, 'getControlPesoGestante']);
    Route::get('/vacunacionGestante', [DashboardGestanteController::class, 'getVacunasGestante']);
    Route::get('/vacunacionBebe', [DashboardGestanteController::class,'getVacunacionBebe']);
    Route::get('/getResutadosItri',[DashboardGestanteController::class, 'getExamenesITrimestre']);
});