<?php

namespace App\Http\Controllers;

use App\Models\Games as ModelsGames;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class games extends Controller
{
    public function newGame(Request $request)
    {
        try {
            //verifico al usuario si es admin o super_admin y si su cuenta es activa.
            $userGameCreator = auth()->user();
            if ($userGameCreator->role === "user" || $userGameCreator->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'no puedes crear juegos'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // validar
            $validator = $this->validateNewGame($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Game not registered',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recoger info
            $title = $request->input('title');
            $description = $request->input('description');
            $id_user = $userGameCreator->id;

            // guardarla
            $newGame = ModelsGames::create(
                [
                    'title' => $title,
                    'description' => $description,
                    'id_user' => $id_user
                ]
            );

            // $games = ModelsGames::get(['*']);
            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Game registered successfully',
                    'data' => $newGame
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
    public function validateNewGame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:100',
            'description' => 'required|min:3|max:250'
        ]);

        return $validator;
    }
}
