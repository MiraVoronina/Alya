<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'ID_User';
    public $timestamps = false;

    protected $fillable = [
        'Login', 'Password', 'ID_User_Role', 'Avatar_url', 'Pets_id', 'role'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'User_ID', 'ID_User');
    }

    public function isAdmin()
    {
        return $this->role === 'admin' || $this->ID_User_Role == 1;
    }
}
