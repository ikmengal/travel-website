<section class="py-16 bg-slate-50/60 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">

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
                <a href="#" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all duration-200 group">
                    View All Tours
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>

        <!-- Slider Container Wrapper with Side Navigation Arrows -->
        <div class="relative px-2">
            <!-- Left Navigation Arrow -->
            <button class="tours-prev-btn absolute -left-5 top-1/2 -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-white text-slate-700 border border-slate-100 shadow-md hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition focus:outline-none disabled:opacity-0 disabled:pointer-events-none lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- Right Navigation Arrow -->
            <button class="tours-next-btn absolute -right-5 top-1/2 -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-white text-slate-700 border border-slate-100 shadow-md hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition focus:outline-none disabled:opacity-0 disabled:pointer-events-none lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <!-- Swiper Container Area -->
            <div class="swiper toursSwiper mt-6">
                <div class="swiper-wrapper">
                    @php
                        $tours = [
                            [
                                'image' => 'bali.jpg',
                                'title' => 'Greek Island Hopping',
                                'days' => '8 Days',
                                'nights' => '7 Nights',
                                'places' => '12+ Places',
                                'old_price' => '1,199',
                                'price' => '959',
                                'rating' => '4.8',
                                'reviews' => '120',
                                'badge' => '-20%',
                                'badge_class' => 'bg-blue-600 text-white'
                            ],
                            [
                                'image' => 'paris.jpg',
                                'title' => 'Canadian Rockies Adventure',
                                'days' => '6 Days',
                                'nights' => '5 Nights',
                                'places' => '8+ Places',
                                'old_price' => '',
                                'price' => '899',
                                'rating' => '4.9',
                                'reviews' => '98',
                                'badge' => 'Best Seller',
                                'badge_class' => 'bg-emerald-500 text-white'
                            ],
                            [
                                'image' => 'dubai.jpg',
                                'title' => 'Kenya Safari Experience',
                                'days' => '5 Days',
                                'nights' => '4 Nights',
                                'places' => '10+ Places',
                                'old_price' => '',
                                'price' => '1,299',
                                'rating' => '4.7',
                                'reviews' => '76',
                                'badge' => 'Hot',
                                'badge_class' => 'bg-amber-500 text-white'
                            ],
                            [
                                'image' => 'hero.jpg',
                                'title' => 'Iceland Northern Lights',
                                'days' => '4 Days',
                                'nights' => '3 Nights',
                                'places' => '6+ Places',
                                'old_price' => '',
                                'price' => '1,099',
                                'rating' => '4.8',
                                'reviews' => '54',
                                'badge' => 'New',
                                'badge_class' => 'bg-violet-600 text-white'
                            ]
                        ];
                    @endphp

                    @foreach($tours as $tour)
                        <div class="swiper-slide group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] hover:shadow-[0_12px_30px_rgba(15,23,42,0.06)] transition-all duration-300 flex flex-col overflow-hidden h-auto">

                            <!-- Image Header Section -->
                            <div class="relative aspect-[1.4/1] w-full overflow-hidden bg-slate-100">
                                <img
                                    src="{{ asset('images/destinations/'.$tour['image']) }}"
                                    alt="{{ $tour['title'] }}"
                                    class="w-full h-full object-cover transform duration-700 ease-out group-hover:scale-105">

                                <!-- Custom Left Badge -->
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wide shadow-sm {{ $tour['badge_class'] }}">
                                        {{ $tour['badge'] }}
                                    </span>
                                </div>

                                <!-- Floating Wishlist Button -->
                                <button class="absolute top-3 right-3 h-8 w-8 rounded-full bg-white/70 backdrop-blur-md text-slate-700 hover:text-red-500 hover:bg-white flex items-center justify-center transition shadow-sm z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-5 flex flex-col flex-1 justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight leading-snug group-hover:text-blue-600 transition-colors duration-200 text-left">
                                        {{ $tour['title'] }}
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2.5 text-[11px] font-semibold text-slate-400 justify-flex-start">
                                        <span>{{ $tour['days'] }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ $tour['nights'] }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-slate-500/90">{{ $tour['places'] }}</span>
                                    </div>
                                </div>

                                <!-- Footer Price & Ratings Layout Row -->
                                <div class="flex items-center justify-between mt-6 pt-3.5 border-t border-slate-100 gap-2">
                                    <div class="flex items-baseline gap-1.5 min-h-[24px]">
                                        @if(!empty($tour['old_price']))
                                            <span class="text-xs text-slate-400 line-through font-medium">${{ $tour['old_price'] }}</span>
                                        @endif
                                        <span class="text-base font-extrabold text-blue-600 tracking-tight">${{ $tour['price'] }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-700 bg-slate-50 border border-slate-100/80 px-2 py-1 rounded-lg">
                                        <span class="text-amber-500 text-xs leading-none">★</span>
                                        <span class="leading-none">{{ $tour['rating'] }}</span>
                                        <span class="text-slate-400 font-medium font-sans text-[10px]">({{ $tour['reviews'] }})</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toursSwiper = new Swiper('.toursSwiper', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            grabCursor: true,
            watchSlidesProgress: true,
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4, // Desktop par pure 4 cards display hongey custom layout k mutabik
                    spaceBetween: 24,
                    allowTouchMove: false, // Desktop grid view ko locked rakhne k liye
                }
            },
            navigation: {
                nextEl: '.tours-next-btn',
                prevEl: '.tours-prev-btn',
            },
        });
    });
</script>
