<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
