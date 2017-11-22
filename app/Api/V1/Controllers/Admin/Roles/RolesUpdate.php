<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Role,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class RolesUpdate extends Controller
{
    /**
     * instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    
    /**
     * Create Roles
     * @ Model Role
     * @@ App\Api\V1\Models\Role
     */
    public function Update(Request $request, $id){

        /**
         * select role by id
         */
        $role = Role::find($id);

        if ($role):

            if($request->input('name')):
                $role->name = $request->input('name');
            endif;

            if($request->input('display_name')):
                $role->display_name = $request->input('display_name');
            endif;

            if($request->input('description')):
                $role->description = $request->input('description');
            endif;

            if($request->input('permissions')):
                $ids = [];
                
                    if(is_array($request->input('permissions'))):
                        foreach($request->input('permissions') as $permission) {
                            $ids[] = intval($permission['id']);
                        }
                    else:
                        foreach($request->input('permissions') as $permission) {
                            $ids[] = intval($permission->id);
                        }
                    endif;

                // add permissions
                $role->syncPermissions($ids);
            endif;

            $done = $role->save();

            if($done): // if role got update start

                return response()->json([
                    'body' => $done,
                    'status'  => [
                       'code' => 200
                      ]
                    ], 200);

            else: // if role got update end

                return response()->json(['message' => 'Update got error for role: '.$role->name], 412);

            endif;


        else:

            return response()->json([
                'body' => [
                  'message' => "Error to update this Role!",
                  'status' => 'warning'
                ]]);
            
        endif;

    }
}