<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 1)
            ->with(['category', 'tags', 'comments'])
            ->latest('published_at')
            ->paginate(9);

        $categories = BlogCategory::where('status', 1)
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 1);
            }])
            ->orderBy('name')
            ->get();

        $recentBlogs = Blog::where('status', 1)
            ->with(['category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.blogs.index', compact('blogs', 'categories', 'recentBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 1)
            ->with(['category', 'tags', 'comments' => function ($q) {
                $q->where('status', 1)->orderBy('sort_order');
            }])
            ->firstOrFail();

        $blog->increment('views');

        $relatedBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->with(['category'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = BlogCategory::where('status', 1)
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 1);
            }])
            ->orderBy('name')
            ->get();

        $recentBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->with(['category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.blogs.show', compact('blog', 'relatedBlogs', 'categories', 'recentBlogs'));
    }
}
