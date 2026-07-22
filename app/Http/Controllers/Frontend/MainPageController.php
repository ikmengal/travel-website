<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class MainPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
