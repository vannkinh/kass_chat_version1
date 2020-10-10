<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function booking(){
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function shop(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }
    public function image(){
        return $this->hasMany(Image::class, 'item_id')->where('type','table');
    }

    protected $table = "tables";

    protected $fillable = [
        'name',
        'max_people',
        'shap',
        'floor',
        'price',
        'special_price',
        'shop_id',
        'deposit',
        'description',
        'image_id',
        'status',
        'created_at',
        'updated_at',
    ];

}
