<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    App\Api\V1\Models\Role,
    App\Api\V1\Models\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class RolesList extends Controller
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
     * @return array list roles 
     */
    public function list(Request $request){
        
        if (!Auth::user()->ability(['admin.roles'], ['read'])):
            return 'no permission';
        endif;

        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $roles = Role::paginate($limit);

        $perm = [];
        foreach ($roles as $p) {
            $per = [];
            foreach ($p->permissions as $n) {
                $per[] = $n->name;
            }

            $perm[] = [
                'id' => $p->id,
                'name' => $p->name,
                'display_name' => $p->display_name,
                'description' => $p->description,
                'permissions' => implode(', ', $per)
            ];
        }

        return response()->json([
            'body' => $perm,
            'meta' => [
                'limit'   => $roles->perPage(),
                'page'    => $roles->currentPage(),
                'total'   => $roles->total(),
                'last'    => $roles->lastPage()
            ],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}