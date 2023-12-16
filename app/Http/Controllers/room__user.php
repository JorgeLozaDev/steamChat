<?php

namespace App\Http\Controllers;

use App\Models\Room_User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class room__user extends Controller
{
    public function room__user(Request $request)
    {
        try {
             $games = Room_User::get(['*']);

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
