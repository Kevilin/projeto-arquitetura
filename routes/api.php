<?php

use App\Http\Controllers\AjusteDePrecoController;
use App\Http\Controllers\IndiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getIndiceMeses/{indice}', [IndiceController::class, 'getIndiceMeses']);
Route::get('/getIndicePeriodo/{indice}', [IndiceController::class, 'getIndicePeriodo']);
Route::get('/ajusteDePrecoPeriodo/{indice}/{preco}', [AjusteDePrecoController::class, 'ajusteDePrecoPeriodo']);

