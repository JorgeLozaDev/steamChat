<?php

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

Route::get('/users', [player_users::class, 'users']);
Route::get('/rooms', [rooms::class, 'rooms']);
Route::get('/room__user', [room__user::class, 'room__user']);
Route::get('/games', [games::class, 'games']);
