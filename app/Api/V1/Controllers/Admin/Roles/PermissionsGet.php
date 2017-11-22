<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Auth;

class PermissionsGet extends Controller
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
     * @return array list roles 
     */
    public function Get(Request $request, $id){
 
        if (!Auth::User()->ability(['admin.permissions'], ['read'])):
            return response()->json(['body' => ['message' => __('lang.admin.permissions.read')]]);
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