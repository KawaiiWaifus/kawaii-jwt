<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    App\Api\V1\Models\Role,
    App\Api\V1\Models\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class PermissionsCreate extends Controller
{
    /**
     * instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api','role:admin.roles']);
    }

    /**
     * Create Permissions
     * @ Model Permission
     * @@ App\Api\V1\Models\Permission
     */
    public function CreatePermission(Request $request){

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
            $permission->display_name = $request->input('display_name');
            $permission->description = $request->input('description');
            $permission->save();

            return response()->json([
                'body' => [
                    'message' => "Permission $permission->name created with seuccess!",
                    'status' => 'success'
                    ]]);

        endif;

    }
}