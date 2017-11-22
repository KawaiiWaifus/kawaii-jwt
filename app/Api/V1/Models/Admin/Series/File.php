<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Model Files.
     * @var string
     */
    protected $table = 'series_files';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'category', 'pivot', 'created_at', 'updated_at'
    ];

    public function image(){
        return $this->hasOne(FilesImage::class);
    }

    public function serie(){
        return $this->hasOne(Serie::class, 'id', 'serie_id');
    }

    public function links(){
        return $this->hasMany(Files::class, 'file_id', 'id');
    }

}