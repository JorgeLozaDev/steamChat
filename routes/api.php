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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//USERS
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [player_users::class, 'listUsers']);
    Route::put('/user/{id}', [player_users::class, 'updateUser']);
    Route::delete('/user/{id}', [player_users::class, 'deleteUserById']);
});

//ROOMS
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/room', [rooms::class, 'newRoom']);
    Route::get('/rooms', [rooms::class, 'listRooms']);
    Route::put('/room/{id}', [rooms::class, 'updateRoom']);
});

//ROOM_USER
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/room__user', [room__user::class, 'room__user']);
});

//GAMES
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/games', [games::class, 'newGame']);
    Route::get('/games', [games::class, 'listGames']);
    Route::put('/games/{id}', [games::class, 'updateGames']);
    Route::delete('/games/{id}', [games::class, 'deleteGamesById']);
});
