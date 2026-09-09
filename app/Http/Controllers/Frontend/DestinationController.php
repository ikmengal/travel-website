<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with(['reviews', 'wishlists', 'country'])
            ->active()
            ->orderBy('sort_order')
            ->get();

        return view('frontend.destinations.index', compact('destinations'));
    }

    public function show($slug)
    {
        $destination = Destination::with(['reviews', 'wishlists', 'country', 'state', 'city', 'tours', 'hotels', 'faqs'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedTours = $destination->tours()->active()->with(['category', 'reviews'])->take(4)->get();
        $relatedHotels = $destination->hotels()->where('status', 1)->with(['images', 'reviews'])->take(4)->get();
        $topDestinations = Destination::active()->where('id', '!=', $destination->id)->with(['country', 'reviews'])->take(4)->get();

        return view('frontend.destinations.show', compact('destination', 'relatedTours', 'relatedHotels', 'topDestinations'));
    }
}
