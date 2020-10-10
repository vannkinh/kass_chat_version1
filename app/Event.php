<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function shop(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }
    public function ticket(){
        return $this->hasMany(Ticket::class, 'event_id');
    }
     public function image(){
        return $this->hasMany(Image::class, 'item_id')->where('type','event');
    }

    protected $table = "events";

    protected $fillable = [
        'name',
        'shop_id',
        'start_date',
        'end_date',
        'description',
        'image_id',
        'status',
        'price',
        'special_price',
        'available_ticket',
        'soldout_ticket',
        'created_at',
        'updated_at',
    ];
}
