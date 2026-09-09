<section class="py-16 bg-slate-50/60 overflow-hidden" id="tours">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1.5">
                    POPULAR TOURS
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Featured Tour Packages
                </h2>
            </div>

            <div class="shrink-0 text-left">
                <a href="{{ route('frontend.tours.index') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all duration-200 group">
                    View All Tours
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>

        <!-- Tour Cards Grid -->
        @if (isset($tours) && !blank($tours))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($tours as $key => $tour)
                    @php
                        $badgeColors = [
                            'bg-blue-600 text-white',
                            'bg-emerald-500 text-white',
                            'bg-amber-500 text-white',
                            'bg-violet-600 text-white',
                            'bg-rose-500 text-white',
                            'bg-cyan-600 text-white',
                        ];
                        $badgeColor = $badgeColors[$key % count($badgeColors)];
                    @endphp
                    <a href="{{ route('frontend.tours.show', $tour->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.03)] hover:shadow-[0_16px_40px_rgba(15,23,42,0.10)] transition-all duration-300 hover:-translate-y-1 flex flex-col overflow-hidden h-full">
                        <!-- Image Header -->
                        <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                            <img
                                src="{{ $tour->featured_image }}"
                                alt="{{ $tour->title ?? '' }}"
                                class="w-full h-full object-cover transform duration-700 ease-out group-hover:scale-105">

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

                            <button class="absolute top-3 right-3 h-8 w-8 rounded-full bg-white/70 backdrop-blur-md text-slate-700 hover:text-red-500 hover:bg-white flex items-center justify-center transition shadow-sm z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-1.5 text-[10px] font-semibold text-blue-600 uppercase tracking-wider mb-1.5">
                                <span>{{ $tour->category->name ?? 'Tour' }}</span>
                            </div>

                            <h3 class="font-bold text-slate-800 text-base tracking-tight leading-snug group-hover:text-blue-600 transition-colors duration-200">
                                {{ $tour->title ?? '' }}
                            </h3>

                            @if(!empty($tour->tagline))
                                <p class="text-xs text-slate-500 mt-1">{{ $tour->tagline }}</p>
                            @endif

                            <div class="flex items-center gap-1.5 mt-3 text-[11px] font-semibold text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span>{{ $tour->duration_days ?? 2 }} Days</span>
                                <span class="text-slate-300">•</span>
                                <span>{{ $tour->duration_nights ?? 3 }} Nights</span>
                            </div>

                            <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100 gap-2 mt-auto">
                                <div class="flex items-baseline gap-1.5">
                                    @if(!empty($tour->discount_price))
                                        <span class="text-xs text-slate-400 line-through font-medium">
                                            {{ ($tour->currency_symbol ?? '$') . number_format($tour->price ?? 0) }}
                                        </span>
                                    @endif
                                    <span class="text-lg font-extrabold text-blue-600 tracking-tight">
                                        {{ ($tour->currency_symbol ?? '$') . number_format($tour->discount_price ?? $tour->price) }}
                                    </span>
                                </div>

                                <div class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 bg-slate-50 border border-slate-100/80 px-2 py-1 rounded-lg">
                                    <span class="text-amber-500 text-xs leading-none">★</span>
                                    <span class="leading-none">{{ $tour->rating ?? '4.0' }}</span>
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
