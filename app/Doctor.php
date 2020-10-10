<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function hospital(){
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function image(){
        return $this->hasMany(Image::class, 'item_id')->where('type','doctor');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    protected $table = "doctors";

    protected $fillable = [
        'hospital_id',
        'name',
        'service_id',
        'degree',
        'work_experience',
        'work_hours',
        'age',
        'gender',
        'satatus',
        

    ];
}
