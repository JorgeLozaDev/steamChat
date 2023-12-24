<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chat_Room;
use App\Http\Controllers\games;
use App\Http\Controllers\player_users;
use App\Http\Controllers\room__user;
use App\Http\Controllers\rooms;
use Illuminate\Support\Facades\Route;

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

//GAMES
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/games', [games::class, 'newGame']);
    Route::get('/games', [games::class, 'listGames']);
    Route::put('/games/{id}', [games::class, 'updateGames']);
    Route::delete('/games/{id}', [games::class, 'deleteGamesById']);
});

//ROOMS
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/room', [rooms::class, 'newRoom']);
    Route::get('/rooms', [rooms::class, 'listRooms']);
    Route::put('/room/{id}', [rooms::class, 'updateRoom']);
    Route::delete('/room/{id}', [rooms::class, 'deleteRoomById']);
});

//CHAT_ROOM
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/{id}', [chat_room::class, 'newMessage']);
    Route::get('/chat', [chat_room::class, 'listAllMessage']);
    Route::put('/chat/{id}', [chat_room::class, 'updateMessage']);
    Route::delete('/chat/{id}', [chat_room::class, 'deleteMessage']);
});

//ROOM_USER
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/room__user', [room__user::class, 'room__user']);
});

