<?php

namespace App\Http\Controllers;

use App\Models\Games as ModelsGames;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class games extends Controller
{
    public function games(Request $request)
    {
        try {
             $games = ModelsGames::get(['*']);

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
