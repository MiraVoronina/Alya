<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'ID_Review';
    public $timestamps = true;

    protected $fillable = [
        'User_ID', 'Services_ID', 'Rating', 'Content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'ID_User');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'Services_ID', 'ID_Services');
    }
}
