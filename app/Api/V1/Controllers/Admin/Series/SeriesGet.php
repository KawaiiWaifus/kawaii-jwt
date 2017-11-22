<?php

namespace App\Api\V1\Controllers\Admin\Series;

use App\Api\V1\Models\Admin\Series\Serie,
    App\Api\V1\Controllers\Controller,
    Illuminate\Http\Request;

class SeriesGet extends Controller 
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
    public function Get($id)
    {
        $series = [];

        $series = Serie::with(['images', 'genres'])->find($id);

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