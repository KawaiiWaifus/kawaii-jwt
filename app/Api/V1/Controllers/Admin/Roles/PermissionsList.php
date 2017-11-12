<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class PermissionsList extends Controller
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

        $permissions = Permission::paginate($limit);

        $perm = [];
        foreach ($permissions as $p) {
            $per = [];
            foreach ($p->roles as $n) {
                $per[] = $n->name;
            }

            $perm[] = [
                'id' => $p->id,
                'name' => $p->name,
                'display_name' => $p->display_name,
                'description' => $p->description,
                'roles' => implode(', ', $per)
            ];
        }

        return response()->json([
            'body' => $perm,
            'meta' => [
                'limit'   => $permissions->perPage(),
                'page'    => $permissions->currentPage(),
                'total'   => $permissions->total(),
                'last'    => $permissions->lastPage()
            ],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}