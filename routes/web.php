<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DentaireController;
use App\Http\Controllers\EchographeController;
use App\Http\Controllers\LaboController;
use App\Http\Controllers\Labo2Controller;
use App\Http\Controllers\MaterniteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/vente/ticket-pdf-consultation/{id}', [ConsultationController::class,'generatePDF']);
Route::get('/vente/ticket-pdf-dentaire/{id}', [DentaireController::class,'generatePDF']);
Route::get('/vente/ticket-pdf-echographe/{id}', [EchographeController::class,'generatePDF']);
Route::get('/vente/ticket-pdf-labo/{id}', [LaboController::class,'generatePDF']);
Route::get('/vente/ticket-pdf-labo2/{id}', [Labo2Controller::class,'generatePDF']);
Route::get('/vente/ticket-pdf-maternite/{id}', [MaterniteController::class,'generatePDF']);
