<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function room(){
        return $this->belongsTo(Room::class, 'id');
    }
    public function table(){
        return $this->belongsTo(Table::class, 'id');
    }
    public function event(){
        return $this->belongsTo(Event::class, 'id');
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class, 'id');
    }
    public function service(){
        return $this->belongsTo(Service::class, 'id');
    }
}
