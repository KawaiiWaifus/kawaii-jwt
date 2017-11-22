<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class FilesImage extends Model
{
    /**
     * Model subs.
     * @var string
     */
    protected $table = 'series_files_images';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'id', 'file_id', 'pivot', 'created_at', 'updated_at'
    ];
}