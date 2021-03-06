<?php

namespace App\Api\V1\Controllers\Admin\Users;

use App\User,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class Update extends Controller 
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
                $user->profile = json_encode($request->input('profile'));
            endif;

            if($request->input('gender')):
                $user->gender = $request->input('gender');
            endif;

            if($request->input('paswword')):
                $user->paswword = bcrypt($request->input('paswword'));
            endif;

            if($request->input('roles')):
                $ids = [];
                
                    if(is_array($request->input('roles'))):
                        foreach($request->input('roles') as $role) {
                            $ids[] = intval($role['id']);
                        }
                    else:
                        foreach($request->input('roles') as $role) {
                            $ids[] = intval($role->id);
                        }
                    endif;

                // add permissions
                $user->syncRoles($ids);
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

}