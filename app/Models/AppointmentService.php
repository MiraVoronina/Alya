<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentService extends Model
{
    protected $table = 'appointment_services';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ID_Appointments',
        'ID_Services'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'ID_Services', 'ID_Services');
    }
}
