<?php

namespace App\Api\V1\Controllers\Series\Categories;

use App\Api\V1\Models\Series\Category,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
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
    public function list(Request $request){
        
        if (!Auth::user()->ability(['admin.roles'], ['read'])):
            return 'no permission';
        endif;

        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $category = Category::where('id', '!=', 10)->paginate($limit);

        return response()->json([
            'body' => $category->items(),
            'meta' => [
                'limit'   => $category->perPage(),
                'page'    => $category->currentPage(),
                'total'   => $category->total(),
                'last'    => $category->lastPage()
            ],
                'status'  => [
                'code' => 200
            ]
        ], 200);
    }
}