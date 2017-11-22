<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Genre,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class Genres extends Controller
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
     * @return array list Genres 
     */
    public function list(Request $request){
        
        if (!Auth::user()->ability(['admin.roles'], ['read'])):
            return 'no permission';
        endif;

        $limit = 200;

        if($request->input('limit')):
           // $limit = $request->input('limit');
        endif;

        $Genre = Genre::paginate($limit);

        return response()->json([
            'body' => $Genre->items(),
            'meta' => [
                'limit'   => $Genre->perPage(),
                'page'    => $Genre->currentPage(),
                'total'   => $Genre->total(),
                'last'    => $Genre->lastPage()
            ],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}