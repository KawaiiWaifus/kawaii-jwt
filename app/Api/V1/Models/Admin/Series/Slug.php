<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    /**
     * Model subs.
     * @var string
     */
    protected $table = 'series_slugs';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'id', 'serie_id', 'pivot', 'created_at', 'updated_at'
    ];
}