<?php

namespace App\Api\V1\Controllers\Auth;


use Illuminate\Support\Facades\Auth,
    App\Api\V1\Requests\Auth\LoginRequest,
    App\Api\V1\Controllers\Controller;


class LoginController extends Controller
{   

   /**
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = Auth::guard()->attempt($credentials)) {

            $roles = [];
  
            foreach (Auth::user()->roles()->get() as $p) {

                $permission = [];

                foreach ($p->permissions as $s) {
                    $permission[] = ['permission' => $s->level];
                }

                $roles += [
                  $p->name => $permission
                ];
            }

            return response()->json([
                'body' => [
                'token' => $token,
                'user' => [
                  'id' => Auth::user()->id,
                  'name' => Auth::user()->name,
                  'email' => Auth::user()->email
                ],
                'permissions' => $roles,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
                ]
            ], 200);

        } // if false continue

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}