<?php

namespace App\Api\V1\Controllers\Admin\Users;

use App\Api\V1\Models\User,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class Get extends Controller 
{
    /**
     * instance.
     * @return void
     **/
    public function __construct()
    {
        $this->middleware('auth:api',/*'role:admin',*/ []);
    }

    /**
     * @function get user
     */
    public function get($id)
    {
        $user = [];

        $user = User::find($id);

        if ($user):

            return response()->json([
                'body' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'telephone' => $user->telephone,
                    'active' => $user->active,
                    'gender' => $user->gender,
                    'address' => $user->address,
                    'amount' => $user->amount,
                    'permissions' => json_decode($user->permissions),
                    'profile' => json_decode($user->profile)
                ],
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No user in DB!'], 412);

        endif;
    }
}