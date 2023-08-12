<?php

namespace App\Http\Controllers\API;

use App\Models\BookingDate;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BookingDateResource;
use App\Http\Resources\API\BookingDateCollection;

class BookingDateController extends Controller
{
    public function index(BookingDate $booking_date)
    {
        return new BookingDateCollection($booking_date->latest()->get());
    }

    public function show(BookingDate $booking_date)
    {
        return new BookingDateResource($booking_date);
    }
}
