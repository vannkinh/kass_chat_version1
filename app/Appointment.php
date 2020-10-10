<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'id');
    }

    protected $table = "appointments";

    protected $fillable = [
        'user_id',
        'doctor_id',
        'hospital_id',
        'start_date',
        'status',
        'comment',
        'created_at',
        'updated_at',
    ];
}
