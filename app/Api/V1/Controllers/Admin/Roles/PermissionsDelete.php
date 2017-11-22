<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller, Auth;

class PermissionsDelete extends Controller
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
     * @function delete Permission
     */
    public function Delete($id) {

        if (!Auth::User()->ability(['admin.permissions'], ['destroy'])):
            return response()->json([
                'body' => [
                    'message' => __('lang.admin.permissions.destroy')
                ], 
                'meta' => [], 
                'status' => [
                    'code' => 412
                    ]
                ], 412);
        endif;

        $permissions = Permission::find($id);

        $permissions->delete();

        return response()->json([
            'body' => ['message' => 'Permission deleted with success!'],
            'meta' => [],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}