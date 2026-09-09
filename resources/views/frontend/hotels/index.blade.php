@extends('layouts.app')

@section('title', 'All Hotels - TravelBook')

@section('content')

<section class="relative h-[46vh] min-h-[380px] overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/destinations/hero.jpg') }}" alt="Hotels" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <span class="text-blue-400 text-xs font-bold uppercase tracking-[.15em]">Accommodation</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mt-3">Hotels</h1>
            <p class="text-slate-300 mt-3 text-base max-w-lg">Find the perfect hotel for your stay with the best prices and amenities.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        @if($hotels->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($hotels as $hotel)
                    @php
                        $hotelImage = $hotel->images->first();
                    @endphp
                    <a href="{{ route('frontend.hotels.show', $hotel->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.03)] hover:shadow-[0_16px_40px_rgba(15,23,42,0.10)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ $hotelImage ? asset($hotelImage->image) : asset('images/destinations/hero.jpg') }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                            @if($hotel->star_rating)
                                <div class="absolute top-3 left-3 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500 text-white shadow-sm">
                                    {{ $hotel->star_rating }} &#9733;
                                </div>
                            @endif
                            @if($hotel->featured)
                                <div class="absolute top-3 right-3 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-600 text-white shadow-sm">
                                    Featured
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-1.5 text-[10px] font-semibold text-blue-600 uppercase tracking-wider mb-1.5">
                                {{ $hotel->destination->name ?? 'Hotel' }}
                            </div>
                            <h3 class="font-bold text-slate-800 text-base group-hover:text-blue-600 transition-colors">{{ $hotel->name }}</h3>
                            @if($hotel->short_description)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $hotel->short_description }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">
                                <div>
                                    <span class="text-lg font-extrabold text-blue-600">{{ '$' . number_format($hotel->starting_price) }}</span>
                                    <span class="text-xs text-slate-500">/ night</span>
                                </div>
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
        @else
            <p class="text-center text-slate-400 py-12">No hotels available yet.</p>
        @endif
    </div>
</section>

@endsection
