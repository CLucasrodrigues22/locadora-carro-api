<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'loginUser');
    Route::post('register', 'createUser');
    Route::post('refresh', 'refresh');
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::Apiresource('cliente', 'App\Http\Controllers\ClienteController');
    Route::Apiresource('carro', 'App\Http\Controllers\CarroController');
    Route::Apiresource('locacao', 'App\Http\Controllers\LocacaoController');
    Route::Apiresource('marca', 'App\Http\Controllers\MarcaController');
    Route::Apiresource('modelo', 'App\Http\Controllers\ModeloController');
});
