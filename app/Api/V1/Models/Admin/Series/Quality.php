<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
    /**
     * Model quality.
     * @var string
     */
    protected $table = 'series_files_quality';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'id', 'pivot', 'created_at', 'updated_at'
    ];
}