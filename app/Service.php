<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function hospital(){
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class, 'service_id')->with('image');
    }
    public function image(){
        return $this->hasMany(Image::class, 'item_id')->where('type','service');
    }
}
