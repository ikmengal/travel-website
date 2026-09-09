@extends('layouts.app')

@section('title', $hotel->meta_title ?: $hotel->name . ' - TravelBook')

@section('content')

<section class="relative h-[50vh] min-h-[420px] overflow-hidden bg-[#031129]">
    @php
        $heroImage = $hotel->featuredImage?->image ? asset($hotel->featuredImage->image) : ($hotel->images->first() ? asset($hotel->images->first()->image) : asset('images/destinations/hero.jpg'));
    @endphp
    <div class="absolute inset-0 z-0">
        <img src="{{ $heroImage }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>
    </div>
    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-6">
        <div>
            <div class="flex items-center gap-3 text-sm text-slate-300 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.hotels.index') }}" class="hover:text-white transition">Hotels</a>
                <span>/</span>
                <span class="text-blue-400 font-semibold">{{ $hotel->name }}</span>
            </div>
            <div class="flex items-center gap-3 mb-3">
                @if($hotel->star_rating)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-white">{{ $hotel->star_rating }} &#9733; Hotel</span>
                @endif
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white">{{ $hotel->name }}</h1>
            @if($hotel->destination)
                <p class="text-slate-300 mt-2 text-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    {{ $hotel->address ?? $hotel->destination->name }}
                </p>
            @endif
            <div class="flex items-center gap-4 mt-3 text-sm text-slate-300">
                @if($hotel->rating)
                    <span class="flex items-center gap-1 text-amber-400"><span>&#9733;</span> {{ $hotel->rating }} ({{ $hotel->reviews_count ?? $hotel->reviews->count() }} reviews)</span>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 space-y-10">

            @if($hotel->short_description)
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-4">About This Hotel</h2>
                <p class="text-slate-600 leading-7">{{ $hotel->short_description }}</p>
            </div>
            @endif

            @if($hotel->description)
            <div>
                <div class="prose prose-lg max-w-none prose-headings:font-black prose-headings:text-slate-900 prose-p:text-slate-700 prose-img:rounded-2xl">{!! $hotel->description !!}</div>
            </div>
            @endif

            @if($hotel->images->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($hotel->images as $image)
                        <div class="rounded-xl overflow-hidden aspect-[4/3]">
                            <img src="{{ asset($image->image) }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($hotel->amenities->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Amenities</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($hotel->amenities as $amenity)
                        <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3">
                            <span class="text-blue-600">&#10003;</span>
                            <span class="text-sm font-medium text-slate-700">{{ $amenity->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($hotel->rooms->count())
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6">Room Types</h2>
                <div class="space-y-4">
                    @foreach($hotel->rooms as $room)
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $room->name }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ $room->description ?? 'Comfortable room with modern amenities' }}</p>
                            </div>
                            <span class="text-lg font-extrabold text-blue-600 whitespace-nowrap">${{ number_format($room->price ?? 0) }}<span class="text-xs text-slate-500 font-normal">/night</span></span>
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
                        <span class="text-3xl font-black text-blue-600">${{ number_format($hotel->starting_price) }}</span>
                        <span class="text-sm text-slate-500">/ night</span>
                    </div>

                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-slate-600"><span>Star Rating</span><span class="font-bold text-slate-900">{{ $hotel->star_rating ?? 'N/A' }} &#9733;</span></div>
                        <div class="flex justify-between text-slate-600"><span>Destination</span><span class="font-bold text-slate-900">{{ $hotel->destination->name ?? 'N/A' }}</span></div>
                        @if($hotel->check_in_time)
                            <div class="flex justify-between text-slate-600"><span>Check-in</span><span class="font-bold text-slate-900">{{ $hotel->check_in_time }}</span></div>
                        @endif
                        @if($hotel->check_out_time)
                            <div class="flex justify-between text-slate-600"><span>Check-out</span><span class="font-bold text-slate-900">{{ $hotel->check_out_time }}</span></div>
                        @endif
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-blue-600/20">
                        Book Now
                    </button>
                </div>

                @if($hotel->phone || $hotel->email)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h4 class="font-bold text-slate-900 mb-3">Contact Info</h4>
                    @if($hotel->phone)
                        <p class="text-sm text-slate-600 flex items-center gap-2 mb-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg> {{ $hotel->phone }}</p>
                    @endif
                    @if($hotel->email)
                        <p class="text-sm text-slate-600 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg> {{ $hotel->email }}</p>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@if($relatedHotels->count())
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-slate-900 mb-8">Related Hotels</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedHotels as $rh)
                @php
                    $rhImage = $rh->images->first();
                @endphp
                <a href="{{ route('frontend.hotels.show', $rh->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        <img src="{{ $rhImage ? asset($rhImage->image) : asset('images/destinations/hero.jpg') }}" alt="{{ $rh->name }}" class="w-full h-full object-cover transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors">{{ $rh->name }}</h3>
                        <span class="text-lg font-extrabold text-blue-600 mt-2 block">${{ number_format($rh->starting_price) }}<span class="text-xs text-slate-500 font-normal">/night</span></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
