<section class="py-16 bg-slate-50/50 overflow-hidden" id="testimonials">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">
                    TESTIMONIALS
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    What Our Travelers Say
                </h2>
            </div>

            <div class="shrink-0 text-left">
                <a href="#" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 group">
                    View All Reviews
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>

        @php
            $reviews = [
                [
                    "name"=>"Sarah Johnson",
                    "country"=>"New York, USA",
                    "avatar"=>"user6.png",
                    "review"=>"Amazing experience! Everything was perfectly organized and the trip was beyond my expectations.",
                ],
                [
                    "name"=>"Michael Chen",
                    "country"=>"Toronto, Canada",
                    "avatar"=>"user7.png",
                    "review"=>"The best travel platform I've used. Great prices, excellent service, and unforgettable memories!",
                ],
                [
                    "name"=>"Emma Williams",
                    "country"=>"London, UK",
                    "avatar"=>"user5.png",
                    "review"=>"Highly recommended! The customer support was excellent and the trip was incredible.",
                ],
                [
                    "name"=>"Sophie Moore",
                    "country"=>"Sydney, Australia",
                    "avatar"=>"user2.png",
                    "review"=>"Highly professional team and amazing tour packages. Everything was hassle free.",
                ],
                [
                    "name"=>"David Miller",
                    "country"=>"Vancouver, Canada",
                    "avatar"=>"user1.png",
                    "review"=>"The best vacation we've ever had. Every detail was perfectly organized.",
                ]
            ];
        @endphp

        <div class="relative px-4 sm:px-0">
            <div class="swiper testimonialSwiper">
                <div class="swiper-wrapper">
                    @foreach($reviews as $review)
                        <div class="swiper-slide h-auto">
                            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] flex flex-col justify-between h-full">

                                <div>
                                    <div class="flex items-center gap-0.5 text-amber-400 text-xs mb-4">
                                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <img
                                            src="{{ asset('images/users/'.$review['avatar']) }}"
                                            alt="{{ $review['name'] }}"
                                            class="w-11 h-11 rounded-full object-cover bg-slate-100 shrink-0">
                                        <div>
                                            <h3 class="font-bold text-slate-800 text-sm tracking-tight leading-snug">
                                                {{ $review['name'] }}
                                            </h3>
                                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">
                                                {{ $review['country'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-5 text-xs sm:text-sm text-slate-500 font-medium leading-relaxed flex-1">
                                    “{{ $review['review'] }}”
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="testimonial-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-3 sm:-translate-x-6 z-20">
                <button class="w-10 h-10 bg-white text-slate-600 rounded-full shadow-md hover:bg-blue-600 hover:text-white flex items-center justify-center transition border border-slate-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
            </div>

            <div class="testimonial-next absolute right-0 top-1/2 translate-x-3 sm:translate-x-6 -translate-y-1/2 z-20">
                <button class="w-10 h-10 bg-white text-slate-600 rounded-full shadow-md hover:bg-blue-600 hover:text-white flex items-center justify-center transition border border-slate-50 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>

            <div class="testimonial-pagination mt-8 flex justify-center gap-1.5"></div>
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        new Swiper(".testimonialSwiper", {
            loop: true,
            spaceBetween: 24,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".testimonial-next",
                prevEl: ".testimonial-prev",
            },
            pagination: {
                el: ".testimonial-pagination",
                clickable: true,
                bulletClass: 'w-2 h-2 rounded-full bg-slate-200 cursor-pointer transition-all duration-300 inline-block mx-1',
                bulletActiveClass: 'bg-blue-600 !w-5 shadow-sm'
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 16,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                }
            }
        });
    });
</script>
