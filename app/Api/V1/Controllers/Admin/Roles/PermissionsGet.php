<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class PermissionsGet extends Controller
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
    public function Get(Request $request, $id){
        
        if (!Auth::user()->ability(['admin.roles'], ['update'])):
            return 'no permission';
        endif;

        $permissions = Permission::find($id);

        if ($permissions):

        return response()->json([
            'body' => $permissions,
            'status' => [
            'code' => 200
            ]
        ], 200);

        else:

            return response()->json([
                'body' => ['message' => 'No permission in DB.'],
                'status'  => [
                'code' => 412
                ]
            ], 200);

        endif;
    }
}