@extends('layouts.app')

@section('title', 'All Tours - TravelBook')

@section('content')

<section class="relative h-[46vh] min-h-[380px] overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/destinations/hero.jpg') }}" alt="Tours" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <span class="text-blue-400 text-xs font-bold uppercase tracking-[.15em]">Packages</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mt-3">Tour Packages</h1>
            <p class="text-slate-300 mt-3 text-base max-w-lg">Find the perfect tour package for your next adventure.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        @if($tours->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($tours as $key => $tour)
                    @php
                        $badgeColors = ['bg-blue-600 text-white', 'bg-emerald-500 text-white', 'bg-amber-500 text-white', 'bg-violet-600 text-white', 'bg-rose-500 text-white', 'bg-cyan-600 text-white'];
                        $badgeColor = $badgeColors[$key % count($badgeColors)];
                    @endphp
                    <a href="{{ route('frontend.tours.show', $tour->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.03)] hover:shadow-[0_16px_40px_rgba(15,23,42,0.10)] transition-all duration-300 hover:-translate-y-1 flex flex-col overflow-hidden h-full">
                        <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                            <img src="{{ $tour->featured_image }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                            <div class="absolute top-3 left-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide shadow-sm {{ $badgeColor }}">
                                    {{ $tour->reviews_count ?? 0 }} Reviews
                                </span>
                            </div>
                            @if(!empty($tour->discount_price))
                                <div class="absolute bottom-3 left-3 z-10">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide bg-red-500 text-white shadow-sm">
                                        SAVE {{ $tour->discount_price ? round((($tour->price - $tour->discount_price) / $tour->price) * 100) : 0 }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-1.5 text-[10px] font-semibold text-blue-600 uppercase tracking-wider mb-1.5">
                                <span>{{ $tour->category->name ?? 'Tour' }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base tracking-tight leading-snug group-hover:text-blue-600 transition-colors duration-200">{{ $tour->title }}</h3>
                            @if(!empty($tour->tagline))
                                <p class="text-xs text-slate-500 mt-1">{{ $tour->tagline }}</p>
                            @endif
                            <div class="flex items-center gap-1.5 mt-3 text-[11px] font-semibold text-slate-400">
                                <span>{{ $tour->duration_days ?? 2 }} Days</span>
                                <span class="text-slate-300">&bull;</span>
                                <span>{{ $tour->duration_nights ?? 3 }} Nights</span>
                            </div>
                            <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100 mt-auto">
                                <div class="flex items-baseline gap-1.5">
                                    @if(!empty($tour->discount_price))
                                        <span class="text-xs text-slate-400 line-through font-medium">{{ ($tour->currency_symbol ?? '$') . number_format($tour->price ?? 0) }}</span>
                                    @endif
                                    <span class="text-lg font-extrabold text-blue-600 tracking-tight">{{ ($tour->currency_symbol ?? '$') . number_format($tour->discount_price ?? $tour->price) }}</span>
                                </div>
                                <div class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 bg-slate-50 border border-slate-100/80 px-2 py-1 rounded-lg">
                                    <span class="text-amber-500 text-xs leading-none">&#9733;</span>
                                    <span>{{ $tour->rating ?? '4.0' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-400 py-12">No tour packages available yet.</p>
        @endif
    </div>
</section>

@endsection
