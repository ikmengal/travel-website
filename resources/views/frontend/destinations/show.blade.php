@extends('layouts.app')

@section('title', $destination->meta_title ?: $destination->name . ' - TravelBook')

@section('content')

<section class="relative h-[50vh] min-h-[420px] overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img src="{{ $destination->featured_image }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <div class="flex items-center gap-3 text-sm text-slate-300 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.destinations.index') }}" class="hover:text-white transition">Destinations</a>
                <span>/</span>
                <span class="text-blue-400 font-semibold">{{ $destination->name }}</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white">{{ $destination->name }}</h1>
            <p class="text-slate-300 mt-3 text-lg max-w-2xl">{{ $destination->tagline ?? $destination->short_description }}</p>
            <div class="flex items-center gap-4 mt-4 text-sm text-slate-300">
                @if($destination->country)
                    <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg> {{ $destination->country->name }}</span>
                @endif
                @if($destination->reviews->count())
                    <span class="flex items-center gap-1 text-amber-400"><span>&#9733;</span> {{ number_format($destination->reviews->avg('rating'), 1) }} ({{ $destination->reviews->count() }} reviews)</span>
                @endif
            </div>
        </div>
    </div>
</section>

@if($destination->short_description)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-4xl">
            <span class="text-blue-600 text-xs font-bold uppercase tracking-[.15em]">About This Destination</span>
            <h2 class="text-3xl font-black text-slate-900 mt-3">Welcome to {{ $destination->name }}</h2>
            <p class="mt-4 text-slate-600 leading-7 text-base">{{ $destination->short_description }}</p>
        </div>
    </div>
</section>
@endif

@if($destination->description)
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="prose prose-lg max-w-none prose-headings:font-black prose-headings:text-slate-900 prose-p:text-slate-700 prose-img:rounded-2xl prose-img:shadow-xl">
            {!! $destination->description !!}
        </div>
    </div>
</section>
@endif

@if($relatedTours->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">TOURS IN {{ strtoupper($destination->name) }}</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tour Packages</h2>
            </div>
            <a href="{{ route('frontend.tours.index') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md hover:bg-blue-700 transition-all duration-200 group">
                View All Tours <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedTours as $tour)
                <a href="{{ route('frontend.tours.show', $tour->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.03)] hover:shadow-[0_16px_40px_rgba(15,23,42,0.10)] transition-all duration-300 hover:-translate-y-1 flex flex-col overflow-hidden h-full">
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                        <img src="{{ $tour->featured_image }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                        @if(!empty($tour->discount_price))
                            <div class="absolute bottom-3 left-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide bg-red-500 text-white shadow-sm">
                                    SAVE {{ $tour->discount_price ? round((($tour->price - $tour->discount_price) / $tour->price) * 100) : 0 }}%
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-slate-800 text-base tracking-tight leading-snug group-hover:text-blue-600 transition-colors">{{ $tour->title }}</h3>
                        <div class="flex items-center gap-1.5 mt-3 text-[11px] font-semibold text-slate-400">
                            <span>{{ $tour->duration_days ?? 2 }} Days</span>
                            <span class="text-slate-300">&bull;</span>
                            <span>{{ $tour->duration_nights ?? 3 }} Nights</span>
                        </div>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100 mt-auto">
                            <span class="text-lg font-extrabold text-blue-600">{{ ($tour->currency_symbol ?? '$') . number_format($tour->discount_price ?? $tour->price) }}</span>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 bg-slate-50 border border-slate-100 px-2 py-1 rounded-lg">
                                <span class="text-amber-500 text-xs leading-none">&#9733;</span>
                                <span>{{ $tour->rating ?? '4.0' }}</span>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($relatedHotels->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">HOTELS IN {{ strtoupper($destination->name) }}</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Recommended Hotels</h2>
            </div>
            <a href="{{ route('frontend.hotels.index') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md hover:bg-blue-700 transition-all duration-200 group">
                View All Hotels <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedHotels as $hotel)
                <a href="{{ route('frontend.hotels.show', $hotel->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.03)] hover:shadow-[0_16px_40px_rgba(15,23,42,0.10)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        @php
                            $hotelImage = $hotel->images->first();
                        @endphp
                        <img src="{{ $hotelImage ? asset($hotelImage->image) : asset('images/destinations/hero.jpg') }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                        @if($hotel->star_rating)
                            <div class="absolute top-3 left-3 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500 text-white shadow-sm">
                                {{ $hotel->star_rating }} &#9733;
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 text-base group-hover:text-blue-600 transition-colors">{{ $hotel->name }}</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-lg font-extrabold text-blue-600">{{ ($hotel->currency_symbol ?? '$') . number_format($hotel->starting_price) }}</span>
                            @if($hotel->rating)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 bg-slate-50 border border-slate-100 px-2 py-1 rounded-lg">
                                    <span class="text-amber-500">&#9733;</span> {{ $hotel->rating }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($destination->faqs->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-10">
                <span class="text-blue-600 text-xs font-bold uppercase tracking-[.15em]">FAQs</span>
                <h2 class="text-3xl font-black text-slate-900 mt-3">Frequently Asked Questions</h2>
            </div>
            @foreach($destination->faqs->take(6) as $faq)
                <div x-data="{ open: false }" class="rounded-2xl bg-white border border-slate-100 shadow-sm mb-4 overflow-hidden" :class="open ? 'border-blue-100' : ''">
                    <button @click="open = !open" class="flex w-full items-center justify-between p-6 text-left">
                        <h3 class="font-bold text-base text-slate-900 pr-4" :class="open ? 'text-blue-600' : ''">{{ $faq->question }}</h3>
                        <span class="h-6 w-6 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 shrink-0 transform transition-transform duration-200" :class="open ? 'rotate-180 bg-blue-50 text-blue-600' : ''">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </span>
                    </button>
                    <div x-show="open" x-collapse x-cloak>
                        <div class="px-6 pb-6 text-sm text-slate-500 leading-relaxed border-t border-slate-50 pt-3">{!! $faq->answer !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($topDestinations->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-blue-600 text-xs font-bold uppercase tracking-[.15em]">Explore More</span>
            <h2 class="text-3xl font-black text-slate-900 mt-3">Top Destinations</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($topDestinations as $dest)
                <a href="{{ route('frontend.destinations.show', $dest->slug) }}" class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    <img src="{{ $dest->featured_image }}" alt="{{ $dest->name }}" class="absolute inset-0 w-full h-full object-cover transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 inset-x-0 p-4 z-10">
                        <h3 class="text-white font-bold text-lg">{{ $dest->name }}</h3>
                        <p class="text-xs text-slate-200 mt-1">{{ $dest->country->name ?? '' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
