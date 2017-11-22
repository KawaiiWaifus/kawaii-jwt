<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Auth;

class PermissionsCreate extends Controller
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
    public function CreatePermission(Request $request){

        if (!Auth::User()->ability(['admin.permissions'], ['create'])):
            return response()->json(['body' => ['message' => __('lang.admin.permissions.create')]]);
        endif;

        /**
         * select permission by name
         */
        $permission = Permission::where('name', '=', 
        $request->input('name'))
                ->first();
        
        if ($permission):

            return response()->json([
                'body' => [
                    'message' => "Permission $permission->name already exists and can not be added again!",
                    'status' => 'warning'
                    ]]);

        else:

            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->level = $request->input('level');
            $permission->display_name = $request->input('display_name');
            $permission->description = $request->input('description');
            $permission->save();

            return response()->json([
                'body' => ['id' => $permission->id],
                'meta' => [],
                'status' => ['code' => 200, 'message' => "Permission $permission->name created with seuccess!"]
                ]);

        endif;

    }
}