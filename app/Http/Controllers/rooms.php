<?php

namespace App\Http\Controllers;

use App\Models\Rooms_Table;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class rooms extends Controller
{
    public function listRooms(Request $request)
    {
        try {
            $rooms = Rooms_Table::get(['*']);
            return response()->json(
                [
                    'success' => true,
                    'message' => 'GAME LIST',
                    'data' => $rooms
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
