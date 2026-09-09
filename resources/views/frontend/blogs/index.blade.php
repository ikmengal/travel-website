@extends('layouts.app')

@section('title', 'Blog - TravelBook')

@section('content')

<section class="relative h-[46vh] min-h-[380px] overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/destinations/hero.jpg') }}" alt="Blog" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <span class="text-blue-400 text-xs font-bold uppercase tracking-[.15em]">Our Blog</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mt-3">Travel Stories & Tips</h1>
            <p class="text-slate-300 mt-3 text-base max-w-lg">Get inspired with travel tips, destination guides, and adventure stories.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2">
                @if($blogs->count())
                    <div class="grid sm:grid-cols-2 gap-6">
                        @foreach($blogs as $blog)
                            <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                                <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
                                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                                    @if($blog->category)
                                        <div class="absolute top-3 left-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-blue-600 text-white shadow-sm">{{ $blog->category->name }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium mb-2">
                                        <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg> {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}</span>
                                        <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg> {{ $blog->author ?? 'Admin' }}</span>
                                        <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg> {{ $blog->views ?? 0 }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-base leading-snug group-hover:text-blue-600 transition-colors">{{ $blog->title }}</h3>
                                    @if($blog->short_description)
                                        <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ Str::limit(strip_tags($blog->short_description), 120) }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <p class="text-center text-slate-400 py-12">No blog posts available yet.</p>
                @endif
            </div>

            <div class="lg:col-span-1 space-y-8">

                @if($categories->count())
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $cat)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-slate-600">{{ $cat->name }}</span>
                                <span class="bg-slate-100 text-slate-500 text-xs font-bold px-2 py-1 rounded-full">{{ $cat->blogs_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($recentBlogs->count())
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Recent Posts</h3>
                    <div class="space-y-4">
                        @foreach($recentBlogs as $rb)
                            <a href="{{ route('frontend.blogs.show', $rb->slug) }}" class="flex items-start gap-3 group">
                                <img src="{{ $rb->featured_image_url }}" alt="{{ $rb->title }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-2">{{ $rb->title }}</h4>
                                    <span class="text-xs text-slate-400 mt-1 block">{{ $rb->published_at ? $rb->published_at->format('d M Y') : '' }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection
