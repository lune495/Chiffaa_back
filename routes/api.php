<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoireController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\AuthController;

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
// Route::get('/histoires',[HistoireController::class, 'index']);
Route::post('/consultation',[ConsultationController::class,'save']);
Route::post('/chapitres',[ChapitreController::class,'save']);
Route::post('/commandes',[CommandeController::class,'save']);
Route::post('/famille_histoires',[FamilleController::class,'save']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/commande', [CommandeController::class,'save']);
Route::get('/payment/checkout', 'PaymentController@checkout');
Route::get('', 'PaymentController@checkout');

Route::group(['middleware' => ['auth:sanctum']],function()
 {
    //return $request->user();
});