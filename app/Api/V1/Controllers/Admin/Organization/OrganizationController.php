<?php

namespace App\Api\V1\Controllers\Admin\Organization;

use App\Api\V1\Models\Admin\Organization\Organization,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class OrganizationController extends Controller 
{
    /**
     * instance.
     * @return void
     **/
    public function __construct()
    {
        $this->middleware('auth:api',/*'role:admin',*/ []);
    }

    /**
     * @function get organization
     */
    public function get($id)
    {
        $organizations = [];

        $organizations = Organization::find($id);

        if ($organizations):

            return response()->json([
                'body' => $organizations,
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No organizations in DB!'], 412);

        endif;
    }

    /**
     * @function list organizations
     */
    public function list(Request $request)
    {
        $organizations = [];
        
        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $organizations = Organization::paginate($limit);

        if ($organizations):

            return response()->json([
                'body' => $organizations->items(),
                'meta' => [
                    'limit'   => $organizations->perPage(),
                    'page'    => $organizations->currentPage(),
                    'total'   => $organizations->total(),
                    'last'    => $organizations->lastPage()
                ],
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No organizations in DB!'], 412);

        endif;
    }
}