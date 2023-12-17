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

            // Actualizar el usuario solo si se proporciona al menos un campo
            if (!$request->has('name') && !$request->has('email') && !$request->has('password')) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No se proporcionaron datos para actualizar',
                        'error' => 'Proporcione al menos un campo (name, email, password) para la actualización.'
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Validar solo los campos proporcionados
            $validatorData = [];

            if ($request->has('name')) {
                $validatorData['name'] = 'min:3|max:100';
            }

            if ($request->has('email')) {
                $validatorData['email'] = ['email', Rule::unique('player_users')->ignore($id)];
            }

            if ($request->has('password')) {
                $validatorData['password'] = 'sometimes|min:6';
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
                $userToUpdate->name = $request->input('name');
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


    public function deleteUserById(Request $request, $id)
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

            // Obtener usuario para realizar la actualización
            $userToUpdate = PlayerUser::find($id);

            if (!$userToUpdate) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User not found',
                        
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            // Realizar la actualización
            $userToUpdate->update(['is_active' => 0]);

            // Devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User marked as inactive successfully',
                    'data' => $userToUpdate
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error marking user as inactive',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
