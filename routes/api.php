<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalhostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return "nuestro mensaje";
});



Route::post("/login_post",[LocalhostController::class,"login"]);
Route::post("/consultar_maestros",[LocalhostController::class,"consultarMaestros"]);
Route::post("/enlazarHuella",[LocalhostController::class,"enlazarHuella"]);