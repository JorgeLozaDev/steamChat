<?php

namespace App\Http\Controllers;

use App\Models\PlayerUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class player_users extends Controller
{
    public function users(Request $request)
    {
        try {
             $games = PlayerUser::get(['*']);

            return response()->json(
                [
                    'succes' => true,
                    'message' => 'usuarios',
                    'data' => $games
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => 'NO',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
