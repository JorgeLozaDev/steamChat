<?php

namespace App\Http\Controllers;

use App\Models\PlayerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // validar
            $validator = $this->validateRegisterDataUser($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User not registered',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recoger info
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            // tratar info
            $encryptedPassword = bcrypt($password);

            // guardarla
            $newUser = PlayerUser::create(
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $encryptedPassword
                ]
            );

            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully',
                    'data' => $newUser
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be registered',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function validateRegisterDataUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:player_users|email',
            'password' => 'required|min:6|max:12'
        ]);

        return $validator;
    }
}
