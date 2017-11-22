<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model,
    App\Api\V1\Models\Series\Category;

class Serie extends Model
{
    /**
     * Model series.
     * @var string
     */
    protected $table = 'series';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function image(){
        return $this->hasOne(Image::class)->select(['image', 'serie_id']);
    }

    public function images(){
        return $this->hasOne(Image::class);
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category')->select(['id', 'name']);
    }

    public function url(){
        return $this->hasOne(Slug::class);
    }

    public function genres(){
        return $this->belongsToMany(Genre::class, 'series_genres');
    }

    public function subs(){
        return $this->belongsToMany(Sub::class, 'series_subs');
    }

    public function files(){
        return $this->hasMany(File::class, 'serie_id', 'id');
    }

}