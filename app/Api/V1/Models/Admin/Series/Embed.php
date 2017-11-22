<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Embed extends Model
{
    /**
     * Model Embed.
     * @var string
     */
    protected $table = 'series_files_links_embed';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'pivot', 'created_at', 'updated_at'
    ];
}