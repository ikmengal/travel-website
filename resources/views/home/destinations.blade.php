<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <!-- Top Header: Subtitle, Main Title, and View All Link -->
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

        <!-- Slider Container Wrapper with Side Navigation Arrows -->
        <div class="relative px-2 sm:px-4">
            <!-- Left Navigation Arrow -->
            <button class="dest-prev-btn absolute -left-2 sm:-left-5 top-1/2 -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-white text-slate-700 border border-slate-100 shadow-md hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition focus:outline-none disabled:opacity-0 disabled:pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- Right Navigation Arrow -->
            <button class="dest-next-btn absolute -right-2 sm:-right-5 top-1/2 -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-white text-slate-700 border border-slate-100 shadow-md hover:bg-slate-50 hover:text-blue-600 flex items-center justify-center transition focus:outline-none disabled:opacity-0 disabled:pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <!-- Swiper Container Area -->
            <div class="swiper destinationsSwiper mt-6">
                <div class="swiper-wrapper">
                    @php
                        $destinations = [
                            ['image'=>'bali.jpg', 'name'=>'Bali, Indonesia', 'price'=>'499', 'rating'=>'4.8'],
                            ['image'=>'dubai.jpg', 'name'=>'Dubai, UAE', 'price'=>'599', 'rating'=>'4.7'],
                            ['image'=>'swiss.jpg', 'name'=>'Switzerland', 'price'=>'799', 'rating'=>'4.9'],
                            ['image'=>'maldives.jpg', 'name'=>'Maldives', 'price'=>'899', 'rating'=>'4.9'],
                            ['image'=>'paris.jpg', 'name'=>'Paris, France', 'price'=>'499', 'rating'=>'4.6'],
                            ['image'=>'hero.jpg', 'name'=>'Tokyo, Japan', 'price'=>'499', 'rating'=>'4.6'],
                            ['image'=>'poland.jpg', 'name'=>'Poznań, Poland', 'price'=>'499', 'rating'=>'4.6']
                        ];
                    @endphp

                    @foreach($destinations as $dest)
                        <!-- Swiper Slide Instance -->
                        <div class="swiper-slide group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">

                            <!-- Base Image filling the entire card view -->
                            <img
                                src="{{ asset('images/destinations/'.$dest['image']) }}"
                                alt="{{ $dest['name'] }}"
                                class="absolute inset-0 w-full h-full object-cover transform duration-700 group-hover:scale-105" />

                            <!-- Bottom Dark Gradient Overlay (transparent to rgba(0,0,0,0.75)) -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/40 to-transparent z-0"></div>

                            <!-- Top Left Corner: Wishlist Heart Button -->
                            <button class="absolute top-3 left-3 h-8 w-8 rounded-full bg-white/20 backdrop-blur-md text-white hover:bg-white hover:text-red-500 flex items-center justify-center transition duration-200 z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3c1.74 0 3.29.831 4.312 2.119C13.02 3.831 14.571 3 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                            </button>

                            <!-- Top Right Corner: Small Blue Badge for Star Rating -->
                            <div class="absolute top-3 right-3 inline-flex items-center gap-0.5 bg-blue-600 px-2 py-1 rounded-lg text-[11px] font-bold text-white z-10 shadow-sm">
                                <span class="text-[10px] text-amber-400">★</span>{{ $dest['rating'] }}
                            </div>

                            <!-- Bottom Overlay Data Wrapper -->
                            <div class="absolute bottom-0 inset-x-0 p-4 flex flex-col text-left z-10">
                                <h3 class="text-white font-bold text-base sm:text-lg tracking-tight leading-tight">
                                    {{ $dest['name'] }}
                                </h3>
                                <p class="text-xs text-slate-200 font-medium mt-1">
                                    From <span class="font-bold text-white text-sm">${{ $dest['price'] }}</span>
                                </p>
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
        const swiper = new Swiper('.destinationsSwiper', {
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
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                }
            },
            navigation: {
                nextEl: '.dest-next-btn',
                prevEl: '.dest-prev-btn',
            },
        });
    });
</script>
