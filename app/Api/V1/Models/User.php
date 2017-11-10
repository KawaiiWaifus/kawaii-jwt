<?php

namespace App\Api\V1\Models;

use Illuminate\Notifications\Notifiable,
    Illuminate\Foundation\Auth\User as Authenticatable,
    Tymon\JWTAuth\Contracts\JWTSubject,
    Zizaco\Entrust\Traits\EntrustUserTrait,
    Config;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'permissions', 'created_at', 'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Api\V1\Models\Role', Config::get('entrust::assigned_roles_table'));
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
