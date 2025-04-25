<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoireController;
use App\Http\Controllers\TypeServiceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\Labo2Controller;
use App\Http\Controllers\MaterniteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\SuiviController;
use App\Http\Controllers\DossierController;
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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/confirmation/{token}', [AuthController::class, 'confirmEmail'])->name('confirmation');
Route::post('/contact',[PlanningController::class,'contacter']);
    
Route::group(['middleware' => ['auth:sanctum']],function()
{
Route::post('/caisse',[CaisseController::class,'save']);
Route::post('/newusercaisse',[CaisseController::class,'newusercaisse']);
Route::post('/annulerRdv/{id}',[PlanningController::class,'annulerRdv']);
Route::post('/prendreRdv',[PlanningController::class,'prendreRdv']);
Route::post('/prendreRdvCaisse',[PlanningController::class,'prendreRdvCaisse']);
Route::post('/planning',[PlanningController::class,'save']);
Route::post('/suivi/{id?}',[SuiviController::class,'save']);
Route::post('/dossier',[DossierController::class,'save']);
Route::post('/update-planning/{id}',[PlanningController::class,'modifierPlanning']);
Route::post('/rdv',[PlanningController::class,'takerdv']);
Route::post('/changestatut/{id}',[CaisseController::class,'statutPDFpharmacie']);
Route::post('/cloture_caisse',[CaisseController::class,'closeCaisse']);
Route::post('/type_service',[TypeServiceController::class,'save']);
Route::post('/module',[ModuleController::class,'save']);
Route::post('/medecin',[MedecinController::class,'save']);
Route::post('/depense',[DepenseController::class,'save']);
Route::post('/labo',[LaboController::class,'save']);
Route::post('/labo2',[Labo2Controller::class,'save']);
Route::post('/annulerRdvSite/{id}',[PlanningController::class,'annulerRdvSiteParId']);
Route::post('/annulerRdvCaisse/{id}',[PlanningController::class,'annulerRdvCaisseParId']);
Route::post('/maternite', [MaterniteController::class,'save']);
Route::post('/updatenotification',[PlanningController::class,'updatenotif']);
});