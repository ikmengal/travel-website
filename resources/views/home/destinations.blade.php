<section class="py-16 bg-white overflow-hidden" id="destinations">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1.5">
                    TOP DESTINATIONS
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Explore Top Destinations
                </h2>
            </div>

            <div class="shrink-0 text-left">
                <a href="#" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all duration-200 group">
                    View All Destinations
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>

        <!-- Destination Cards Grid -->
        @if (isset($destinations) && !blank($destinations))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($destinations as $dest)
                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        <img
                            src="{{ $dest->featured_image }}"
                            alt="{{ $dest->name ?? '' }}"
                            class="absolute inset-0 w-full h-full object-cover transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-0"></div>

                        @if($dest->reviews->count() > 0)
                            <div class="absolute top-3 right-3 inline-flex items-center gap-0.5 bg-blue-600 px-2 py-1 rounded-lg text-[11px] font-bold text-white z-10 shadow-sm">
                                <span class="text-[10px] text-amber-400">★</span>{{ $dest->reviews->count() }}
                            </div>
                        @endif

                        @if(!empty($dest->starting_price))
                            <div class="absolute top-3 left-3 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide text-white bg-black/40 backdrop-blur-md z-10">
                                From <span class="ml-1 text-blue-300">{{ ($dest->currency_symbol ?? 'Rs.') . number_format($dest->starting_price) }}</span>
                            </div>
                        @endif

                        <!-- Bottom Overlay -->
                        <div class="absolute bottom-0 inset-x-0 p-4 flex flex-col text-left z-10">
                            <h3 class="text-white font-bold text-base sm:text-lg tracking-tight leading-tight drop-shadow">
                                {{ $dest->name ?? '' }}
                            </h3>
                            <p class="text-xs text-slate-200 font-medium mt-1 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-blue-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $dest->country->name ?? ($dest->tagline ?? '') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-400 py-12">No destinations available yet.</p>
        @endif
    </div>
</section>
