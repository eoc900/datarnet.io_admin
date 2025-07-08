<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IAGeneratorController;

Route::post('/prompt-json', [IAGeneratorController::class, 'generarJson']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return "nuestro mensaje";
});
