<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Auth;

class PermissionsUpdate extends Controller
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
     * Create Permissions
     * @ Model Permission
     * @@ App\Api\V1\Models\Permission
     */
    public function UpdatePermission(Request $request, $id){

        if (!Auth::User()->ability(['admin.permissions'], ['update'])):
            return response()->json(['body' => ['message' => __('lang.admin.permissions.update')]]);
        endif;

        /**
         * select permission by name
         */
        $permission = [];
        
        $permission = Permission::find($id);
        
        if ($permission): // if has permission in db start

            if($request->input('name')):
                $permission->name = $request->input('name');
            endif;

            if($request->input('level')):
                $permission->level = $request->input('level');
            endif;

            if($request->input('display_name')):
                $permission->display_name = $request->input('display_name');
            endif;

            if($request->input('description')):
                $permission->description = $request->input('description');
            endif;


            $done = $permission->save();


           if($done): // if permission got update start

                return response()->json([
                    'body' => $permission,
                    'status'  => [
                       'code' => 200 
                      ]
                    ], 200);

            else: // if permission got update end

                return response()->json(['message' => 'Update got error for permission: '.$permission->name], 412);

            endif;

        else: // if has permission in db end

            return response()->json(['message' => 'No permission in DB!'], 412);

        endif;
    }
}