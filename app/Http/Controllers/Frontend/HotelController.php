<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Destination;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::where('status', 1)
            ->with(['destination', 'images', 'reviews', 'amenities'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->get();

        $destinations = Destination::active()->orderBy('name')->get();

        return view('frontend.hotels.index', compact('hotels', 'destinations'));
    }

    public function show($slug)
    {
        $hotel = Hotel::with([
            'destination.country', 'destination.state', 'destination.city',
            'images', 'featuredImage', 'rooms', 'reviews', 'amenities', 'faqs'
        ])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $relatedHotels = Hotel::where('status', 1)
            ->where('id', '!=', $hotel->id)
            ->where('destination_id', $hotel->destination_id)
            ->with(['images', 'reviews'])
            ->take(4)
            ->get();

        return view('frontend.hotels.show', compact('hotel', 'relatedHotels'));
    }
}
