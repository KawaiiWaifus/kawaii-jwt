<?php

namespace App\Api\V1\Models\Admin\Series;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    /**
     * Model File.
     * @var string
     */
    protected $table = 'series_files_links';

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'file_id', 'server_id', 'quality_id', 'pivot', 'created_at', 'updated_at'
    ];

    public function server()
    {
        return $this->hasOne(FilesServer::class, 'id', 'server_id');
    }

    public function quality()
    {
        return $this->hasOne(Quality::class, 'id', 'quality_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

}