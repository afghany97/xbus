<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TripController;
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

Route::group(["middleware" => "auth:api"], function ($router) {
    $router->post('logout', [AuthController::class, 'logout']);


    $router->get('trips/{id}/search', [TripController::class, 'search']);
});

Route::post('login', [AuthController::class, 'login']);
