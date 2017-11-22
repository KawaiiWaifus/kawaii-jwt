<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * Model genres.
     * @var string
     */
    protected $table = 'genres';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'pivot', 'created_at', 'updated_at'
    ];

}