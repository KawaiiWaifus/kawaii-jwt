<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Serie,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class SeriesUpdate extends Controller 
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
     * @function get organization
     */
    public function Update(Request $request, $id)
    {

        $series = Serie::with(['images', 'genres'])->find($id);

        if($request->input('genres')):
           $series->genres()->sync([]);
            if (is_array($request->input('genres'))):
                foreach($request->input('genres') as $genre) {
                    $series->genres()->attach($genre['id']);
                }
            else:
                if (is_object($request->input('genres'))) {
                    $genre = $request->input('genres')->id;
                    $series->genres()->attach($genre);
                }
            endif;
        endif;

        // $series->save();

        if ($series):

            return response()->json([
                'body' => $series,
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No series in DB!'], 412);

        endif;
    }

}