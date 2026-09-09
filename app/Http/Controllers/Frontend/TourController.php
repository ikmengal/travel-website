<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\Destination;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::active()
            ->with(['destination', 'category', 'reviews'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->get();

        $categories = TourCategory::where('status', 1)->orderBy('name')->get();
        $destinations = Destination::active()->orderBy('name')->get();

        return view('frontend.tours.index', compact('tours', 'categories', 'destinations'));
    }

    public function show($slug)
    {
        $tour = Tour::with([
            'destination.country', 'destination.state', 'destination.city',
            'category', 'images', 'itineraries', 'includes', 'excludes',
            'departures', 'reviews', 'faqs'
        ])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $tour->increment('views');

        $relatedTours = Tour::active()
            ->where('id', '!=', $tour->id)
            ->where('tour_category_id', $tour->tour_category_id)
            ->with(['destination', 'category', 'reviews'])
            ->take(4)
            ->get();

        return view('frontend.tours.show', compact('tour', 'relatedTours'));
    }
}
