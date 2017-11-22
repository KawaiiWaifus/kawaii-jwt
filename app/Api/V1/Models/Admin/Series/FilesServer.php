<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class FilesServer extends Model
{
    /**
     * Model FilesServer.
     * @var string
     */
    protected $table = 'servers';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'id', 'pivot', 'created_at', 'updated_at'
    ];

}