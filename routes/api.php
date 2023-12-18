<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\games;
use App\Http\Controllers\player_users;
use App\Http\Controllers\room__user;
use App\Http\Controllers\rooms;
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

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //user endpoints
    Route::get('/users', [player_users::class, 'listUsers']);
    Route::put('/user/{id}', [player_users::class, 'updateUser']);
    Route::delete('/user/{id}', [player_users::class, 'deleteUserById']);

    //rooms endpoints
    Route::get('/rooms', [rooms::class, 'rooms']);

    //roo_user endpoints
    Route::get('/room__user', [room__user::class, 'room__user']);

    //games endpoints
    Route::post('/games', [games::class, 'newGame']);
    Route::get('/games', [games::class, 'listGames']);
    Route::delete('/games/{id}', [games::class, 'deleteGamesById']);
});
