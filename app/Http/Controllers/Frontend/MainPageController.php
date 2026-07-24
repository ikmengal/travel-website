<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Member;
use App\Models\Testimonial;

class MainPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::with('images')->where('slug',$slug)
            ->where('status',1)
            ->firstOrFail();

        $relatedPages = Page::where('status',1)
            ->where('id','!=',$page->id)
            ->latest()
            ->take(3)
            ->get();

        $latestBlogs = Blog::where('status',1)
            ->latest()
            ->take(3)
            ->get();

        $faqs = Faq::where('status',1)
            // ->where(function($q){
            //     $q->whereNull('faqable_type')
            //     ->orWhere('faqable_type');
            // })
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $teamMembers = Testimonial::where('status',1)
        ->where('featured',1)
        ->take(4)
        ->get();
        return view('pages.show', get_defined_vars());
    }
}
