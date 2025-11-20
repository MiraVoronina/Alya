
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'User_Role';
    protected $primaryKey = 'ID_User_Role';
    public $timestamps = false;

    protected $fillable = [
        'Role_Name'
    ];
}
