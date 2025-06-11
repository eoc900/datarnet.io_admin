<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\GanttController;
use App\Http\Controllers\Esp8266Controller;
use App\Http\Controllers\LocalhostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return "nuestro mensaje";
});

Route::get('/data', [GanttController::class,'get']);
Route::resource('task', TasksController::class);
Route::resource('link', LinkController::class);



Route::post("/esp8266/data",[Esp8266Controller::class,"prueba"]);
Route::get("/esp8266/prueba",[Esp8266Controller::class,"prueba2"]);


Route::post("/login_post",[LocalhostController::class,"login"]);
Route::post("/consultar_maestros",[LocalhostController::class,"consultarMaestros"]);
Route::post("/enlazarHuella",[LocalhostController::class,"enlazarHuella"]);