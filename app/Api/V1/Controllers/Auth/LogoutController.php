<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Controllers\Controller, Auth;

class LogoutController extends Controller
{
    /**
     * Create a new AuthController instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
    }

    /**
     * Log the user out (Invalidate the token)
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard()->logout();

        return response()
            ->json(['body' => ['message' => 'Successfully logged out']]);
    }
}
