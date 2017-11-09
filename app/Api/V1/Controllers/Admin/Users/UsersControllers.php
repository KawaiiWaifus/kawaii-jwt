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

    /**
     * @function get user
     */
    public function get($id)
    {
        $user = [];

        $user = User::find($id);

        if ($user):

            return response()->json([
                'body' => $user,
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No user in DB!'], 412);

        endif;
    }

    /**
     * @function update user
     */
    public function update(Request $request, $id)
    {
        $user = [];

        $user = User::find($id);

        if ($user): // if has user in db start

            if($request->input('name')):
                $user->name = $request->input('name');
            endif;

            if($request->input('email')):
                $user->email = $request->input('email');
            endif;

            if($request->input('profile')):
                $user->profile = $request->input('profile');
            endif;

            if($request->input('gender')):
                $user->gender = $request->input('gender');
            endif;

            if($request->input('paswword')):
                $user->paswword = $request->input('paswword');
            endif;

            $done = $user->save();

            if($done): // if user got update start

                return response()->json([
                    'body' => $user,
                    'status'  => [
                       'code' => 200
                      ]
                    ], 200);

            else: // if user got update end

                return response()->json(['message' => 'Update got error for user: '.$user->name], 412);

            endif;

        else: // if has user in db end

            return response()->json(['message' => 'No user in DB!'], 412);

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