<section class="py-12 sm:py-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 sm:mb-12 gap-4 sm:gap-6">
            <div class="text-left">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1.5">
                    Our Gallery
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Explore Beautiful Places
                </h2>
                <p class="mt-2 sm:mt-3 max-w-2xl text-sm sm:text-base text-slate-500 leading-relaxed">
                    Discover breathtaking destinations and unforgettable moments from around the world.
                </p>
            </div>
            <div class="shrink-0 text-left">
                <a href="{{ route('frontend.destinations.index') }}" class="inline-flex items-center justify-center w-full sm:w-auto rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all duration-200 group">
                    View All Showcase
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>
        @php
            $gallery1 = $gallery->firstWhere('sort_order', 1);
            $gallery2 = $gallery->firstWhere('sort_order', 2);
            $gallery3 = $gallery->firstWhere('sort_order', 3);

            $otherGallery = $gallery->where('sort_order', '>', 3);
        @endphp
        <div class="grid grid-cols-12 gap-4 sm:gap-6">
            {{-- Left Big Image --}}
            @if($gallery1)
                <div class="group relative col-span-12 lg:col-span-7 h-[300px] sm:h-[400px] lg:h-[480px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                    <img src="{{ $gallery1->image }}" alt="{{ $gallery1->title }}"
                        class="h-full w-full object-cover duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 backdrop-blur-md px-3 py-1 text-xs font-bold text-white border border-white/20">
                            📍 {{ $gallery1->country->name ?? '' }}
                        </span>
                        <h3 class="mt-3 text-3xl font-black text-white">
                            {{ $gallery1->title }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-200">
                            {{ $gallery1->caption }} • {{ $gallery1->category ?? '' }} {{ isset($gallery1->short_description) && !empty($gallery1->short_description) ? '• '.$gallery1->short_description : '' }}
                        </p>
                    </div>
                </div>
            @endif
            {{-- Right Side --}}
            <div class="col-span-12 lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">
                @if($gallery2)
                    <div class="group relative h-[180px] sm:h-[200px] lg:h-[228px] overflow-hidden rounded-2xl shadow hover:shadow-xl">
                        <img src="{{ $gallery2->image }}" alt="{{ $gallery2->title }}"
                            class="h-full w-full object-cover duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                        <div class="absolute bottom-5 left-5">
                            <span class="text-xs font-bold text-blue-400 uppercase">
                                📍 {{ $gallery2->country->name ?? '' }}
                            </span>
                            <h4 class="text-xl font-bold text-white">
                                {{ $gallery2->title }}
                            </h4>
                        </div>
                    </div>
                @endif

                @if($gallery3)
                    <div class="group relative h-[180px] sm:h-[200px] lg:h-[228px] overflow-hidden rounded-2xl shadow hover:shadow-xl">
                        <img src="{{ $gallery3->image }}" alt="{{ $gallery3->title }}"
                            class="h-full w-full object-cover duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                        <div class="absolute bottom-5 left-5">
                            <span class="text-xs font-bold text-blue-400 uppercase">
                                📍 {{ $gallery3->country->name ?? '' }}
                            </span>
                            <h4 class="text-xl font-bold text-white">
                                {{ $gallery3->title }}
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
            {{-- Remaining Gallery --}}
            @foreach($otherGallery as $item)
                <div class="group relative col-span-12 sm:col-span-6 lg:col-span-4 h-[180px] sm:h-[220px] lg:h-[240px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                    <img src="{{ $item->image }}"
                        alt="{{ $item->title }}"
                        class="h-full w-full object-cover duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-5 left-5">
                        <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">
                            {{ $item->category }}
                        </span>
                        <h4 class="text-lg font-extrabold text-white">
                            {{ $item->title }}
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
