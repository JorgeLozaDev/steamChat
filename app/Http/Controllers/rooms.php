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
    public function newRoom(Request $request)
    {
        try {
            //verifico si no es usuario y si su cuenta es activa.
            $userRoomsCreator = auth()->user();
            if ($userRoomsCreator->role === "user" || $userRoomsCreator->is_active === 0) {
                return response()->json(
                    [
                        'succes' => false,
                        'message' => 'UNHAUTORIZED'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // validar
            $validator = $this->validateNewRoom($request);

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
            $id_user = $userRoomsCreator->id;

            // guardarla
            $newGame = Rooms_Table::create(
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

    public function validateNewRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:100',
            'description' => 'required|min:1|max:250'
        ]);

        return $validator;
    }

    public function updateRoom(Request $request, $id)
    {
        try {
            // Obtener el usuario autenticado
            $user = auth()->user();

            // Comprobar si el usuario autenticado tiene permisos para actualizar la sala
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

            // Actualizar la sala solo si se proporciona al menos un campo
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
            $roomToUpdate = Rooms_Table::findOrFail($id);

            // Actualizar campos según la solicitud
            if ($request->has('title')) {
                $roomToUpdate->title = $request->input('title');
            }

            if ($request->has('description')) {
                $roomToUpdate->description = $request->input('description');
            }
            
            if ($request->has('is_active')) {
                $roomToUpdate->is_active = $request->input('is_active');
            }
            
            $roomToUpdate->id_user = $user->id;

            // Guardar los cambios
            $roomToUpdate->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => $roomToUpdate,
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
}
