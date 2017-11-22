<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Serie,
    App\Api\V1\Models\Admin\Series\Genre,
    App\Api\V1\Models\Admin\Series\Subs,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class SeriesList extends Controller 
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
     * @function list series
     */
    public function List(Request $request)
    {
        $limit = 20;
        $orderby = 0;

        if($request->input('limit')):
            $limit = $request->input('limit');
        endif;

        $season   = $request->input('season');
        $title    = $request->input('title');
        $title    = $request->input('query');
        $category = $request->input('list_category');
        $orderby  = $request->input('orderby');

        switch($orderby) {
            case 1:  $by = 'title';  $order = 'ASC';   break;
            case 2:  $by = 'title';  $order = 'DESC';  break;
            case 3:  $by = 'id';     $order = 'DESC';  break;
            case 4:  $by = 'id';     $order = 'ASC';   break;
            default: $by = 'id';     $order = 'DESC';  break;
        }

        // if is season request ----START----
        if($request->input('season')):
            if($title):
                // if title is first letter ----START----
                if($request->input('title_first_letter')):
                    // if is category ---START---
                     if ($request->input('list_category')):
                        $series = Serie::where('season', '=', $season)
                                       ->where('category', '=', $category)
                                       ->where('title', 'like', $title . '%')
                                       ->orderBy($by, $order)->with(['image', 'category'])
                                       ->withCount(['files'])
                                       ->paginate($limit);
                     else:
                        $series = Serie::where('season', '=', $season)
                                       ->where('title', 'like', $title . '%')
                                       ->orderBy($by, $order)->with(['image', 'category'])
                                       ->withCount(['files'])
                                       ->paginate($limit);
                     endif;
                     // if is category ---END---
                else:
                    // if is category ---START---
                    if ($request->input('list_category')):
                       $series = Serie::where('season', '=', $season)
                                      ->where('category', '=', $category)
                                      ->where('title', 'like', '%' . $title . '%')
                                      ->orderBy($by, $order)->with(['image', 'category'])
                                      ->withCount(['files'])
                                      ->paginate($limit);
                    else:
                        $series = Serie::where('season', '=', $season)
                                       ->where('title', 'like', '%' . $title . '%')
                                       ->orderBy($by, $order)->with(['image', 'category'])
                                       ->withCount(['files'])
                                       ->paginate($limit);
                    endif;
                    // if is category ---END---
                endif;
                // if tiititlete is first letter ----END----
            else:
                // if is category ---START---
                if ($request->input('list_category')):
                   $series = Serie::where('season', '=', $season)
                                  ->where('category', '=', $category)
                                  ->orderBy($by, $order)->with(['image', 'category'])
                                  ->withCount(['files'])
                                  ->paginate($limit);
                else:
                    $series = Serie::where('season', '=', $season)
                                 ->orderBy($by, $order)->with(['image', 'category'])
                                 ->withCount(['files'])
                                 ->paginate($limit);
                endif;
                // if is category ---END---
            endif;

        else:
            // if title request is only title ----START----
            if($title):
                // if title is first letter ----START----
                if($request->input('title_first_letter')):
                    // if is category ---START---
                    if ($request->input('list_category')):
                       $series = Serie::where('title', 'like', $title . '%')
                                      ->where('category', '=', $category)
                                      ->orderBy($by, $order)->with(['image', 'category'])
                                      ->withCount(['files'])
                                      ->paginate($limit);
                    else:
                        $series = Serie::where('title', 'like', $title . '%')
                                    ->orderBy($by, $order)->with(['image', 'category'])
                                    ->withCount(['files'])
                                    ->paginate($limit);
                    endif;
                // if is category ---END---                    
                else:
                    // if is category ---START---
                    if ($request->input('list_category')):
                        $series = Serie::where('title', 'like', '%' . $title . '%')
                                       ->where('category', '=', $category)
                                       ->orderBy($by, $order)->with(['image', 'category'])
                                       ->withCount(['files'])
                                       ->paginate($limit);
                    else:
                        $series = Serie::where('title', 'like', '%' . $title . '%')
                                     ->orderBy($by, $order)->with(['image', 'category'])
                                     ->withCount(['files'])
                                     ->paginate($limit);
                    endif;
                    // if is category ---END--- 
                endif;
                // if title is first letter ----END----
            else:
                // if is category ---START---
                if ($request->input('list_category')):
                    $series = Serie::where('category', '=', $category)
                                 ->orderBy($by, $order)->with(['image', 'category'])
                                 ->withCount(['files'])
                                 ->paginate($limit);
                else:
                    $series = Serie::orderBy($by, $order)
                                  ->with(['image', 'category'])
                                  ->withCount(['files'])
                                  ->paginate($limit);
                endif;
                // if is category ---END--- 
            endif;
            // if title request is only title ----END----
        endif;
        // if is season request ----END----


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