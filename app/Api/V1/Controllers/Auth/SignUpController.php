<?php

namespace App\Api\V1\Controllers\Auth;

use Config,
    App\Api\V1\Models\User,
    Tymon\JWTAuth\JWTAuth,
    App\Http\Controllers\Controller,
    App\Api\V1\Requests\SignUpRequest,
    Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('kawaii-jwt.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }
}
