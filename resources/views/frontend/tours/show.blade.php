@extends('layouts.app')

@section('title', $tour->meta_title ?: $tour->title . ' - TravelBook')

@section('content')

<section class="relative h-[50vh] min-h-[420px] overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img src="{{ $tour->featured_image }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <div class="flex items-center gap-3 text-sm text-slate-300 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.tours.index') }}" class="hover:text-white transition">Tours</a>
                <span>/</span>
                <span class="text-blue-400 font-semibold">{{ Str::limit($tour->title, 40) }}</span>
            </div>
            <div class="flex items-center gap-3 mb-3">
                @if($tour->category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white">{{ $tour->category->name }}</span>
                @endif
                @if(!empty($tour->discount_price))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white">SAVE {{ round((($tour->price - $tour->discount_price) / $tour->price) * 100) }}%</span>
                @endif
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white">{{ $tour->title }}</h1>
            @if(!empty($tour->tagline))
                <p class="text-slate-300 mt-2 text-lg">{{ $tour->tagline }}</p>
            @endif
            <div class="flex items-center gap-4 mt-4 text-sm text-slate-300">
                @if($tour->destination)
                    <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg> {{ $tour->destination->name }}</span>
                @endif
                <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg> {{ $tour->duration_days ?? 2 }}D / {{ $tour->duration_nights ?? 3 }}N</span>
                @if($tour->reviews->count())
                    <span class="flex items-center gap-1 text-amber-400"><span>&#9733;</span> {{ number_format($tour->reviews->avg('rating'), 1) }} ({{ $tour->reviews->count() }} reviews)</span>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 space-y-10">

            @if($tour->short_description)
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">Overview</h2>
                <p class="text-slate-600 leading-7">{{ $tour->short_description }}</p>
            </div>
            @endif

            @if($tour->description)
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">Description</h2>
                <div class="prose prose-lg max-w-none prose-headings:font-black prose-headings:text-slate-900 prose-p:text-slate-700 prose-img:rounded-2xl">{!! $tour->description !!}</div>
            </div>
            @endif

            @if($tour->itineraries->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Itinerary</h2>
                <div class="space-y-6">
                    @foreach($tour->itineraries->sortBy('day') as $itinerary)
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-bold">Day {{ $itinerary->day }}</span>
                                <h3 class="font-bold text-slate-900">{{ $itinerary->title }}</h3>
                            </div>
                            <p class="text-slate-600 text-sm leading-7">{!! $itinerary->description !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($tour->includes->count() || $tour->excludes->count())
            <div class="grid sm:grid-cols-2 gap-6">
                @if($tour->includes->count())
                <div class="bg-green-50 rounded-2xl p-6">
                    <h3 class="font-bold text-green-800 mb-4 flex items-center gap-2"><span class="text-green-600">&#10003;</span> What's Included</h3>
                    <ul class="space-y-2">
                        @foreach($tour->includes as $item)
                            <li class="flex items-start gap-2 text-sm text-green-700"><span class="text-green-500 mt-0.5">&#10003;</span> {{ $item->title }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($tour->excludes->count())
                <div class="bg-red-50 rounded-2xl p-6">
                    <h3 class="font-bold text-red-800 mb-4 flex items-center gap-2"><span class="text-red-600">&#10007;</span> What's Excluded</h3>
                    <ul class="space-y-2">
                        @foreach($tour->excludes as $item)
                            <li class="flex items-start gap-2 text-sm text-red-700"><span class="text-red-500 mt-0.5">&#10007;</span> {{ $item->title }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endif

            @if($tour->images->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($tour->images as $image)
                        <div class="rounded-xl overflow-hidden aspect-[4/3]">
                            <img src="{{ asset($image->image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($tour->faqs->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    @foreach($tour->faqs as $faq)
                        <div x-data="{ open: false }" class="rounded-2xl bg-white border border-slate-100 shadow-sm overflow-hidden" :class="open ? 'border-blue-100' : ''">
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
            @endif

        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6">

                <div class="bg-white rounded-2xl border border-slate-100 shadow-lg p-6">
                    <div class="flex items-baseline gap-2 mb-4">
                        @if(!empty($tour->discount_price))
                            <span class="text-sm text-slate-400 line-through font-medium">{{ ($tour->currency_symbol ?? '$') . number_format($tour->price) }}</span>
                        @endif
                        <span class="text-3xl font-black text-blue-600">{{ ($tour->currency_symbol ?? '$') . number_format($tour->discount_price ?? $tour->price) }}</span>
                        <span class="text-sm text-slate-500">/ person</span>
                    </div>

                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-slate-600"><span>Duration</span><span class="font-bold text-slate-900">{{ $tour->duration_days ?? 2 }} Days / {{ $tour->duration_nights ?? 3 }} Nights</span></div>
                        <div class="flex justify-between text-slate-600"><span>Category</span><span class="font-bold text-slate-900">{{ $tour->category->name ?? 'N/A' }}</span></div>
                        <div class="flex justify-between text-slate-600"><span>Destination</span><span class="font-bold text-slate-900">{{ $tour->destination->name ?? 'N/A' }}</span></div>
                        @if($tour->rating)
                            <div class="flex justify-between text-slate-600"><span>Rating</span><span class="font-bold text-slate-900 flex items-center gap-1"><span class="text-amber-500">&#9733;</span> {{ $tour->rating }}/5</span></div>
                        @endif
                    </div>

                    @if($tour->departures->count())
                    <div class="border-t border-slate-100 pt-4 mb-4">
                        <h4 class="font-bold text-sm text-slate-900 mb-3">Available Departures</h4>
                        @foreach($tour->departures->take(3) as $departure)
                            <div class="flex justify-between items-center text-xs py-2 border-b border-slate-50 last:border-0">
                                <span class="text-slate-600">{{ \Carbon\Carbon::parse($departure->departure_date)->format('d M Y') }}</span>
                                <span class="font-bold text-slate-900">{{ ($tour->currency_symbol ?? '$') . number_format($departure->price ?? $tour->price) }}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-blue-600/20">
                        Book Now
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

@if($relatedTours->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-slate-900 mb-8">Related Tours</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedTours as $rt)
                <a href="{{ route('frontend.tours.show', $rt->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        <img src="{{ $rt->featured_image }}" alt="{{ $rt->title }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">{{ $rt->title }}</h3>
                        <span class="text-lg font-extrabold text-blue-600 mt-2 block">{{ ($rt->currency_symbol ?? '$') . number_format($rt->discount_price ?? $rt->price) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
