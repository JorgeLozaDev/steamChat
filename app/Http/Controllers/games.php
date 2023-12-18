<?php

namespace App\Http\Controllers;

use App\Models\Games as ModelGames;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class games extends Controller
{
    public function newGame(Request $request)
    {
        try {
            //verifico si no es usuario y si su cuenta es activa.
            $userGameCreator = auth()->user();
            if ($userGameCreator->role === "user" || $userGameCreator->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'UNHAUTORIZED'
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
            $newGame = ModelGames::create(
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
            'description' => 'required|min:1|max:250'
        ]);

        return $validator;
    }

    public function listGames(Request $request)
    {
        try {
            $userGameCreator = auth()->user();
            //verifico si su cuenta es activa.
            if ($userGameCreator->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'su cuenta ha sido borrada'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $games = ModelGames::get(['id', 'is_active', 'title', 'description']);
            //si es user le muestro cierta información
            if ($userGameCreator->role === "user") {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'GAME LIST',
                        'data' => $games,
                    ],
                    Response::HTTP_OK
                );
            } else {
                //si es admin o super admin devolver todo
                $games = ModelGames::get(['*']);
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'GAME LIST',
                        'data' => $games
                    ],
                    Response::HTTP_OK
                );
            }
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

    public function updateGames(Request $request, $id)
    {
        try {
            
            // Obtener el usuario autenticado
            $user = auth()->user();

            // Comprobar si el usuario autenticado tiene permisos para actualizar el usuario
            if ($user->rol === "user") {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unauthorized',
                        'error' => 'No tienes permiso para estar aqui'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            // Actualizar el usuario solo si se proporciona al menos un campo
            if (!$request->has('title') && !$request->has('description') && !$request->has('is_active')){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se proporcionaron datos para actualizar',
                        'error' => 'Proporcione al menos un campo (title o description) para la actualización.'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Validar solo los campos proporcionados
            $validatorData = [];

            if ($request->has('title')) {
                $validatorData['title'] = 'min:3|max:100';
            }

            if ($request->has('description')) {
                $validatorData['description'] = 'min:1|max:250';
            }

            if ($request->has('is_active')) {
                $validatorData['is_active'] = 'max:2';
            }

            $validator = Validator::make($request->all(), $validatorData);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Error en los campos',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Actualizar el juego
            $gameToUpdate = ModelGames::findOrFail($id);

            // Actualizar campos según la solicitud
            if ($request->has('title')) {
                $gameToUpdate->title = $request->input('title');
            }

            if ($request->has('description')) {
                $gameToUpdate->description = $request->input('description');
            }
            
            if ($request->has('is_active')) {
                $gameToUpdate->is_active = $request->input('is_active');
            }
            
            $gameToUpdate->id_user = $user->id;

            // Guardar los cambios
            $gameToUpdate->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => $gameToUpdate,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error updating user',
                    'error' => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteGamesById(Request $request, $id)
    {
        try {
            //verifico si no es usuario y si su cuenta es activa.
            $userGameCreator = auth()->user();
            if ($userGameCreator->role === "user" || $userGameCreator->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'UNHAUTORIZED'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Obtener juego para realizar el borrado
            $gameToDelete = ModelGames::find($id);

            if (!$gameToDelete) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Game not found',
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            // Realizar la actualización
            $gameToDelete->update(['is_active' => 0]);

            // Devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User marked as inactive successfully',
                    'data' => $gameToDelete
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
