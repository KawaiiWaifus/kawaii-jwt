<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Serie,
    App\Api\V1\Models\Admin\Series\Image,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class SeriesController extends Controller 
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
    public function get($id)
    {
        $series = [];

        $series = Serie::find($id);

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

    /**
     * @function list series
     */
    public function list(Request $request)
    {
        $series = [];
        
        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $series = Serie::paginate($limit);

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

    /**
     * @function list season
     */
    public function season(Request $request)
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

    public function crazy()
    {

        $serie = Serie::select('id', 'title')
            ->where('id', '=', 45)
            ->with([
            'url',
            'images',
            'subs',
            'genres',
            'files' => function ($files) {
                $files->select('id','serie_id','file','file_name','bluray')->paginate(5);
            },
            'files.image:file_id,url',
            'files.links.server:id,name',
            'files.links.quality:id,name,px',
            'files.links:file_id,server_id,quality_id,link,vip'
            ])
            ->first();
            

            // $serie>increment('visits');
            // $serie->files()->where('id', 386)->increment('downloads');

        // $serie->images;

        return response()->json(['serie' => $serie], 200);

/*
        $all = Serie::select('id', 'image')->get();

        foreach ($all as $up) {
                $nice = new Image;
                $nice->serie_id = $up->id;
                if ($up->image):
                  $nice->image = $up->image;
                else:
                  $nice->image = '#';
                endif;
                $nice->save();
        }

        echo 'done';
*/
 // ini_set('max_execution_time', 500);
        /*
        foreach ($all as $up) {

            Series::where('id','=', $up->id)
            ->where('done','=', 0)
            ->update([
              'about' => html_entity_decode(utf8_decode(strip_tags($up->about)), ENT_COMPAT, 'UTF-8'),
              'done' => 1
            ]);
        }*/
    }
}