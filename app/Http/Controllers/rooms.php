<?php

namespace App\Http\Controllers;

use App\Models\Rooms_Table;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class rooms extends Controller
{
    public function rooms(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $games = Rooms_Table::get(['*']);

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
