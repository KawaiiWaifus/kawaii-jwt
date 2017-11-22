<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Role,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class RolesDelete extends Controller
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
     * @return array delete role
     */
    public function Delete($id){
        /*
        if (!Auth::user()->ability(['admin.roles'], ['destroy'])):
            return 'no permission';
        endif;
*/

        $role = Role::find($id);

        $role->delete();

        return response()->json([
            'body' => ['message' => 'Role deleted with success!'],
            'meta' => [],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}