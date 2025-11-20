<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'Status';
    protected $primaryKey = 'ID_Status';
    public $timestamps = false;

    protected $fillable = [
        'Order_Status_Name', 'Updated_at'
    ];
}
