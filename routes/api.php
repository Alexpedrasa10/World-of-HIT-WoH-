<?php

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
 
Route::group(['middleware' => 'player'], function () {

    Route::post('/assignItem', [\App\Http\Controllers\UserController::class, 'assignItem']);
    Route::post('/attackBodyToBody', [\App\Http\Controllers\UserController::class, 'attackBodyToBody']);
    Route::post('/rangedAttack', [\App\Http\Controllers\UserController::class, 'rangedAttack']);
    Route::post('/ulti', [\App\Http\Controllers\UserController::class, 'ulti']);
});

Route::group(['middleware' => 'admin'], function () {
    
    Route::post('/user', [\App\Http\Controllers\AdminController::class, 'createUser']);
    Route::post('/item', [\App\Http\Controllers\AdminController::class, 'createItem']);
    Route::put('/item/{id}', [\App\Http\Controllers\AdminController::class, 'editItem']);
    Route::get('/usersUlti', [\App\Http\Controllers\AdminController::class, 'getUsersUlti']);
});

