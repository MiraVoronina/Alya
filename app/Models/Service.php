<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'ID_Services';
    public $timestamps = false;

    protected $fillable = ['Title', 'Price', 'Breed_category'];
}
