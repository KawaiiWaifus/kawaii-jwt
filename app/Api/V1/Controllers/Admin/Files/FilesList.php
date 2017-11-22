<?php

namespace App\Api\V1\Controllers\Admin\Files;

use App\Api\V1\Models\Admin\Series\File,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request, 
    Auth;

class FilesList extends Controller 
{
    /**
     * instance.
     * @return void
     **/
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * @function list organizations
     */
    public function list(Request $request)
    {

        if (!Auth::User()->ability(['admin.files'], ['read'])):
            return response()->json(['message' => __('lang.admin.files.read')], 403);
        endif;

        $limit = 20;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        if($request->input('serie')):
          $serie = $request->input('serie');
          $files = File::where('serie_id', '=', $serie)
                        ->with(['image', 'serie:id,title,category', 'serie.category:id,name'])
                    ->paginate($limit);
        else:
          $files = File::with(['image', 'serie:id,title,category', 'serie.category:id,name'])
                   ->paginate($limit);
        endif;


        if ($files):

            return response()->json([
                'body' => $files->items(),
                'meta' => [
                    'limit'   => $files->perPage(),
                    'page'    => $files->currentPage(),
                    'total'   => $files->total(),
                    'last'    => $files->lastPage()
                ],
                'status'  => [
                   'code' => 200
                  ]
                ], 200);

        else:

            return response()->json(['message' => 'No files in DB!'], 412);

        endif;
    }
}