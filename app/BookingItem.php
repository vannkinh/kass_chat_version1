<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    
}
