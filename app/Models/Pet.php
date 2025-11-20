<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID', 'Name', 'Breed', 'breed_category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'ID_User');
    }
}
