<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroomingMaster extends Model
{
    protected $table = 'grooming_masters';
    protected $primaryKey = 'ID_Master';
    public $timestamps = false;

    protected $fillable = [
        'name', 'Created_at'
    ];
}
