<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;


    public function facility()
    {
        return $this->belongsTo('App\Models\Facility');
    }

    public function preapproved_by()
    {
        return $this->belongsTo('App\Models\AdminUser', 'preapproved_by');
    }

    public function approved_by()
    {
        return $this->belongsTo('App\Models\AdminUser', 'approved_by');
    }

    public function verified_by()
    {
        return $this->belongsTo('App\Models\AdminUser', 'verified_by');
    }

    public function reviewed_by()
    {
        return $this->belongsTo('App\Models\AdminUser', 'reviewed_by');
    }

    public function booked_by()
    {
        return $this->belongsTo('App\Models\AdminUser', 'booked_by');
    }

    public function booking_dates()
    {
        return $this->hasMany('App\Models\BookingDate');
    }


}
