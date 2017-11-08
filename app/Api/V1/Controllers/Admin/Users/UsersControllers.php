<?php

namespace App\Api\V1\Controllers\Admin\Users;

use App\Api\V1\Models\User,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class UsersControllers extends Controller 
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
     * @function list users
     */
    public function list(Request $request)
    {
        $users = [];

        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $users = User::paginate($limit);

        if ($users):

            return response()->json([
                'body' => $users,
                'meta' => [
                    'limit'   => $users->perPage(),
                    'page'    => $users->currentPage(),
                    'total'   => $users->total(),
                    'last'    => $users->lastPage()
                ],
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No users in DB!'], 412);

        endif;
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