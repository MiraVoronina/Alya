<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'ID_Appointments';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'ID_User');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'Pets_ID', 'ID');
    }

    public function master()
    {
        return $this->belongsTo(GroomingMaster::class, 'ID_Master', 'ID_Master');
    }

    public function appointmentServices()
    {
        return $this->hasMany(AppointmentService::class, 'ID_Appointments', 'ID_Appointments');
    }
}
