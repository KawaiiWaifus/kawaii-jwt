<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Controllers\Controller,
    Auth;

class UserController extends Controller
{
    /**
     * instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
    }

   /**
    * Get the authenticated User
    * @return \Illuminate\Http\JsonResponse
    */
    public function me()
    {
        return response()->json([
            'body' => [
                Auth::guard()->user()
              ]
            ]);
    }
}
