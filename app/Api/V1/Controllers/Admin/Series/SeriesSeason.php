<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Serie,
    App\Api\V1\Models\Admin\Series\Genre,
    App\Api\V1\Models\Admin\Series\Subs,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class SeriesSeason extends Controller 
{
    /*
     * instance.
     * @return void
     
    public function __construct()
    {
        $this->middleware('auth:api',/*'role:admin',* / []);
    }
    **/

    /**
     * @function list season
     */
    public function Season(Request $request)
    {
        $series = [];
        
        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $series = Serie::where('season','=', 1)->paginate($limit);

        if ($series):

            return response()->json([
                'body' => $series->items(),
                'meta' => [
                    'limit'   => $series->perPage(),
                    'page'    => $series->currentPage(),
                    'total'   => $series->total(),
                    'last'    => $series->lastPage()
                ],
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No series in DB!'], 412);

        endif;
    }

}