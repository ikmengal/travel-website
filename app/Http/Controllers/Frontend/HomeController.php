<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Destination,
    Testimonial,
    Partner,
    Gallery,
    Counter,
    Banner,
    Tour, Faq
};

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::orderBy('sort_order')->active()->get();
        $partners = Partner::active()->orderBy('sort_order')->get();

        $destinations = Destination::with(['reviews', 'wishlists', 'country'])->active()
            ->orderBy('sort_order')
            ->get();

        $tours = Tour::active()
            ->with(['destination','category'])
            ->orderBy('sort_order')
            ->orderByDesc('featured')
            ->get();

        $gallery = Gallery::with('country')->active()
            ->featured()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $counters = Counter::active()
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::with(['country', 'state', 'city'])->active()
            ->featured()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $databaseFaqs = Faq::active()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('home.index', get_defined_vars());
    }
}
