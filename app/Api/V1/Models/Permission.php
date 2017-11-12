<?php namespace App\Api\V1\Models;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Support\Facades\Config;

class Permission extends EntrustPermission
{
    protected $hidden = [
        'created_at', 'updated_at', 'pivot'
    ];

     /**
     * @return Illuminate\Database\Eloquent\Model
     */
    public function roles()
    {
        return $this->belongsToMany('App\Api\V1\Models\Role', Config::get('entrust::permission_role_table'));
    }
}