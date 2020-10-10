<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public function doctor()
    {
        return $this->hasMany(Doctor::class, 'hospital_id')->with('image');
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'hospital_id');
    }
    public function skill()
    {
        return $this->hasMany(Skill::class, 'hospital_id');
    }
    public function service()
    {
        return $this->hasMany(Service::class, 'hospital_id');
    }
}
