<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoireController;
use App\Http\Controllers\EchographeController;
use App\Http\Controllers\DentaireController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\LaboController;
use App\Http\Controllers\Labo2Controller;
use App\Http\Controllers\MaterniteController;
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
Route::post('/echographe',[EchographeController::class,'save']);
Route::post('/dentaire',[DentaireController::class,'save']);
Route::post('/labo',[LaboController::class,'save']);
Route::post('/labo2',[Labo2Controller::class,'save']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/maternite', [MaterniteController::class,'save']);
Route::get('/payment/checkout', 'PaymentController@checkout');
Route::get('', 'PaymentController@checkout');

Route::group(['middleware' => ['auth:sanctum']],function()
 {
    //return $request->user();
});