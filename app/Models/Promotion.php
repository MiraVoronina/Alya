<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'ID_Promotion';
    public $timestamps = false;

    protected $fillable = [
        'Title', 'Description', 'Image_url', 'Created_at'
    ];
}
