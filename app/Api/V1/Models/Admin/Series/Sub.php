<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Sub extends Model
{
    /**
     * Model subs.
     * @var string
     */
    protected $table = 'subs';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'id', 'pivot', 'created_at', 'updated_at'
    ];
}