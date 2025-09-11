<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BodyCarController;

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

Route::middleware(['validate_user'])->group(function () {
    Route::post('/vehicle', [VehicleController::class, 'register']);
    Route::get('/status/list', [StatusController::class, 'index']);
    Route::get('/settings/list', [SettingsController::class, 'index']);
    Route::get('/bodycar/list', [BodyCarController::class, 'index']);
});

Route::get('/user/{id}', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'authenticate']);
Route::put('/user/{id}', [UserController::class, 'update']);

