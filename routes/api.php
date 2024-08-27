<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SuperAdminController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* RUTAS DEL SUPERADMIN */

Route::get("superadmin",[SuperAdminController::class, 'index']);
Route::post("superadmin",[SuperAdminController::class, 'store']);
Route::get("superadmin/{id}",[SuperAdminController::class, 'show']);
Route::post("superadmin/{id}",[SuperAdminController::class, 'update']);
Route::delete("superadmin/{id}",[SuperAdminController::class, 'destroy']);