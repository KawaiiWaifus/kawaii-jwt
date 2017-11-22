<?php

namespace App\Api\V1\Controllers\Admin\Users;

use App\User,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class Active extends Controller 
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
     * @function active a user
     */
    public function active(Request $request, $id)
    {
        $status = '';
        $user = User::find($id);

        if ($user->active):

            $status = 'Desativado';
            $user->active = 0;

        else:
            
            $status = 'Ativado';
            $user->active = 1;

        endif;

        $done = $user->save();

        if($done):

            return response()->json(['body' => ['status' => $status]], 200);

        else:

            return response()->json(['message' => 'No users in DB!'], 412);

        endif;
    }
}