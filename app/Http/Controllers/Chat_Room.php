<?php

namespace App\Http\Controllers;

use App\Models\Chat_Room as ModelChat_Room;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class chat_room extends Controller
{
    public function listAllMessage(Request $request)
    {
        try {
            $user = auth()->user();
            //verifico si su cuenta es activa.
            if ($user->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'su cuenta ha sido borrada'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $mesage = ModelChat_Room::get(['*']);
            //si es user le muestro cierta información
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'GAME LIST',
                        'data' => $mesage,
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
    
    public function newMessage(Request $request,$idRoom)
    {
        try {
            $user = auth()->user();
            //verifico si su cuenta es activa.
            if ($user->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'su cuenta ha sido borrada'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            //recoger info
            $id_player_sender = $user->id;
            $id_rom = $idRoom;
            $message = $request->input('message');

            //se guarda
            $newMessage = ModelChat_Room::create(
                [
                    "id_player_sender" => $id_player_sender,
                    "id_room" => $id_rom,
                    "message" => $message
                ],
            );

            //respuesta
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'GAME LIST',
                        'data' => $newMessage
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
