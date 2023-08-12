<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BookingResource;
use App\Http\Resources\API\BookingCollection;

class BookingController extends Controller
{
    public function index(Booking $booking)
    {
        return new BookingCollection($booking->latest()->get());
    }

    public function show(Booking $booking)
    {
        return new BookingResource($booking);
    }

    public function store(Request $request)
    {
        /*$validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer'
        ]);
    
        $book = Book::create($validated);*/
        $booking = Booking::create($request);
        return new BookingResource($booking);
    }

    public function update(Request $request, Booking $booking)
    {
       /* $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer'
        ]);

        $book->update($validated);*/
        $booking->update($request);
        return new BookingResource($booking);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

}
