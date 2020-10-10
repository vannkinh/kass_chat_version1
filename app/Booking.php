<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id')->with('shop');
    }

    public function bookingItem()
    {
        return $this->hasMany(BookingItem::class, 'booking_id');
    }

    protected $table = "bookings";

    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'start_date',
        'end_date',
        'discount',
        'subtotal',
        'total',
        'paymentMethod',
        'status',
        'comment',
        'created_at',
        'updated_at',
    ];
}
