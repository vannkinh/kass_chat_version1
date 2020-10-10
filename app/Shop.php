<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function room()
    {
        return $this->hasMany(Room::class, 'shop_id')->with('image');
    }
    public function table()
    {
        return $this->hasMany(Table::class, 'shop_id')->with('image');
    }
    public function event()
    {
        return $this->hasMany(Event::class, 'shop_id')->with('image');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class, 'shop_id');
    }

    protected $table = "shops";
}
