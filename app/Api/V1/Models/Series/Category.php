<?php namespace App\Api\V1\Models\Series;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

     /**
     * @return Illuminate\Database\Eloquent\Model
     */
    protected $table = 'categories';
}