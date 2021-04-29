<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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

Route::resource('group', GroupController::class)->only([
    'store', 'update', 'destroy'
]);

Route::resource('user', UserController::class)->only([
    'store', 'update', 'destroy'
]);

Route::post('asign',[UserController::class, 'asignate']);
