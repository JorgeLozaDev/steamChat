<?php

namespace App\Http\Controllers;

use App\Models\PlayerUser;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

    public function updateUser(Request $request, $id)
    {
        try {
            // Validar la solicitud
            $validator = Validator::make($request->all(), [
                'name' => 'min:3|max:100',
                'email' => ['email', Rule::unique('player_users')->ignore($id)],
                'password' => 'sometimes|min:6',
            ]);

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

            // Obtener el usuario autenticado
            $user = auth()->user();

            // Comprobar si el usuario autenticado tiene permisos para actualizar el usuario
            if ($user->id != $id) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unauthorized',
                        'error' => 'No tienes permiso para estar aqui'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            // Actualizar el usuario
            $userToUpdate = PlayerUser::findOrFail($id);

            // Actualizar campos según la solicitud


            if ($request->has('email')) {
                $userToUpdate->email = $request->input('email');
            }
            // Actualizar la contraseña si se proporciona
            if ($request->has('password')) {
                $userToUpdate->password = bcrypt($request->input('password'));
            }

            if ($request->has('name')) {
                $userToUpdate->name = $request->input('name');;
            }

            // Guardar los cambios
            $userToUpdate->save();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User updated successfully',
                    'data' => $userToUpdate,
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

    public function deletUserById(Request $request, $id)
    {
        try {

            // Obtener el usuario autenticado
            $user = auth()->user();

            // Comprobar si el usuario autenticado tiene permisos para actualizar el usuario
            if ($user->id != $id) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unauthorized',
                        'error' => 'No tienes permiso para realizar esta acción'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            // Elimnar usuario
            $deletUser = PlayerUser::find($id);

            if (!$deletUser) {
                throw new Error('user not found');
            }

            $deletUser->delete();

            // Devolver tarea
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User deleted successfully',
                    'data' => $deletUser
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {

            if ($th->getMessage() === 'User not found') {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User not found',
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cant delete User',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
