<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Role,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class RolesGet extends Controller
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
     * @return array get roles 
     */
    public function Get($id){
   /*     
        if (!Auth::user()->ability(['admin.roles'], ['read'])):
            return 'no permission';
        endif;
*/

        $roles = Role::find($id);
        $roles->permissions;
/*
        $perm = [];
            $per = [];
            foreach ($roles->permissions as $n) {
                $per[] = $n->id;
            }

            $perm[] = [
                'id' => $roles->id,
                'name' => $roles->name,
                'display_name' => $roles->display_name,
                'description' => $roles->description,
                'add_permissions' => $per
            ];
*/
        return response()->json([
            'body' => $roles,
            'meta' => [],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}