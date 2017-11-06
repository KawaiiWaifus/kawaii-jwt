<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Controllers\Controller, Auth;

class RefreshController extends Controller
{

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
    }
    
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = Auth::guard()->refresh();

        return response()->json([
            'body' => [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]
        ]);
    }
    
}
