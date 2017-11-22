<?php

namespace App\Api\V1\Controllers\Admin\Users;

use App\User,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class ListUsers extends Controller
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
                'body' => $users->items(),
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

}