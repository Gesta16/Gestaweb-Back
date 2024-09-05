<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SuperAdminController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\IpsController;
use App\Http\Controllers\API\OperadorController;
use App\Http\Controllers\API\UsuarioController;

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

    /** RUTAS DE LA Usuario */

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
