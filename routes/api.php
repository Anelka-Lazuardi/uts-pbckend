<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Routing for api patients
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login'])->name('login');


// All api must insert token .
// for getting token just login
// if u dont have token just register :)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patiens', [PatientController::class, 'index']);
    Route::post('/patiens', [PatientController::class, 'store']);
    Route::get('/patiens/{patient:id}', [PatientController::class, 'show']);
    Route::put('/patiens/{patient:id}', [PatientController::class, 'update']);
    Route::delete('/patiens/{patient:id}', [PatientController::class, 'destroy']);
    Route::get('/patiens/search/{name}', [PatientController::class, 'search']);
    Route::get('/patiens/status/positive', [PatientController::class, 'positive']);
    Route::get('/patiens/status/recovered', [PatientController::class, 'recovered']);
    Route::get('/patiens/status/dead', [PatientController::class, 'dead']);
});
