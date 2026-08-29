@push('css')
    <style>
        .heroSlider{
            position:relative;
        }

        .heroSlider .swiper-slide-active .hero-bg{
            animation:heroZoom 7s ease forwards;
        }

        @keyframes heroZoom{
            from{
                transform:scale(1);
            }
            to{
                transform:scale(1.08);
            }
        }

        .hero-title{
            opacity:0;
            transform:translateY(40px);
        }

        .swiper-slide-active .hero-title{
            opacity:1;
            transform:translateY(0);
            transition:1s;
        }

        .hero-text{
            opacity:0;
            transform:translateY(40px);
        }

        .swiper-slide-active .hero-text{
            opacity:1;
            transform:translateY(0);
            transition:1.2s .2s;
        }

        .travelTag{
            opacity:0;
            transform:translateX(-60px);
        }

        .swiper-slide-active .travelTag{
            opacity:1;
            transform:translateX(0);
            transition:1s;
        }

        .infoCard1,
        .infoCard2{
            opacity:0;
            transform:translateX(120px);
        }

        .swiper-slide-active .infoCard1{
            opacity:1;
            transform:translateX(0);
            transition:1s;
        }

        .swiper-slide-active .infoCard2{
            opacity:1;
            transform:translateX(0);
            transition:1s .25s;
        }

        /* .heroSlider .swiper-button-next,
        .heroSlider .swiper-button-prev{
            color:#fff;
            width:55px;
            height:55px;
            border-radius:50%;
            background:rgba(255,255,255,.15);
            backdrop-filter:blur(10px);
            z-index:50;
        }

        .heroSlider .swiper-button-next::after,
        .heroSlider .swiper-button-prev::after{
            font-size:20px;
            font-weight:700;
        }

        .heroSlider .swiper-button-next,
        .heroSlider .swiper-button-prev,
        .heroSlider .swiper-pagination{
            z-index:999;
        } */
    </style>
@endpush
<div class="swiper heroSlider">
    <div class="swiper-wrapper">
        @foreach($banners as $key => $banner)
            @php
                $badgeClasses = [
                    'bg-blue-500/10 text-blue-500 flex items-center border border-blue-500',
                    'bg-cyan-500/10 text-cyan-500 flex items-center border border-cyan-500',
                    'bg-purple-500/10 text-purple-400 flex items-center backdrop-blur-md border border-purple-500',
                    'bg-amber-500/10 text-amber-400 flex items-center backdrop-blur-md border border-amber-500',
                ];
                $badgeClass = $badgeClasses[$key % count($badgeClasses)];
            @endphp
            <div class="swiper-slide">
                <section class="relative h-screen min-h-[800px] max-h-[900px] flex flex-col justify-between overflow-hidden bg-[#031129]">
                    <div class="absolute inset-0 z-0">
                        <img
                            src="{{ $banner->image }}"
                            alt="{{ $banner->title }}"
                            class="hero-bg w-full h-full object-cover object-center">
                            <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.05) 100%);"></div>
                    </div>

                    <div class="relative w-full max-w-7xl mx-auto px-6 lg:px-8 pt-10 pb-12 z-20 my-auto">
                        <div class="grid lg:grid-cols-12 gap-8 items-center">
                            <div class="lg:col-span-7 flex flex-col items-start space-y-6">
                                <div class="travelTag inline-flex items-center gap-2 rounded-full bg-slate-900/40 backdrop-blur-md px-4 py-2 border border-white/10 text-white text-xs font-semibold tracking-wide uppercase">
                                    <span class="text-blue-400 text-sm">✈</span> {{ $banner->subtitle ?? $banner->title ?? '#1 Travel Booking Platform' }}
                                </div>

                                <h3 class="hero-title text-3xl sm:text-4xl lg:text-[2.75rem] xl:text-5xl font-extrabold tracking-tight text-white leading-[1.2]">
                                    {{ $banner->subtitle_1 ?? '' }}
                                    <span class="block text-lg sm:text-xl lg:text-2xl font-semibold text-blue-300 mt-3">
                                        {{ $banner->subtitle_2 ?? '' }}
                                    </span>
                                </h3>

                                <p class="hero-text max-w-xl text-sm sm:text-base text-slate-200 font-normal leading-relaxed drop-shadow-sm">
                                    {{ $banner->description ?? "breathtaking destinations, luxury stays, unforgettable experiences, and exclusive travel packages designed for modern explorers." }}
                                </p>

                                @if(!empty($banner->subtitle_3))
                                    <div class="hero-text inline-flex items-center gap-2 rounded-full bg-blue-500/15 border border-blue-500/30 backdrop-blur-md px-4 py-2 text-xs font-semibold text-blue-200">
                                        <span class="text-amber-400">★</span> {{ $banner->subtitle_3 }}
                                    </div>
                                @endif

                                <div class="flex flex-wrap items-center gap-6 pt-2">
                                    <a href="{{ $banner->button_url ?: '#' }}" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 hover:from-blue-500 hover:to-blue-400 transition-all duration-200 group">
                                        {{ $banner->button_text ?? 'Explore Tours' }}
                                        <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                                    </a>
                                    <div class="flex items-center gap-3">
                                        <div class="flex -space-x-2">
                                            <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="{{ asset('admin/assets/img/avatars/10.png') }}" alt="User">
                                            <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="User">
                                            <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="{{ asset('admin/assets/img/avatars/4.png') }}" alt="User">
                                            <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="{{ asset('admin/assets/img/avatars/2.png') }}" alt="User">
                                        </div>
                                        <div>
                                            <div class="text-white font-bold text-base leading-none">{{ $banner->avatars_data ?? '50K+' }}</div>
                                            <div class="text-slate-200 text-xs mt-0.5">Happy Travelers</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="lg:col-span-5 relative w-full h-[380px] hidden lg:block">
                                <div class="infoCard1 absolute top-0 right-4 w-80 bg-white p-3 rounded-2xl shadow-xl flex items-center gap-4 z-10">
                                    <img src="{{ $banner->image }}" class="w-16 h-16 rounded-xl object-cover" alt="Bali">
                                    <div>
                                        <h4 class="text-slate-800 font-bold text-sm">{{ $banner->card_location ?? "Bali, Indonesia"}}</h4>
                                        <p class="text-slate-400 text-xs">{{ $banner->card_para ?? "French Polynesia" }}</p>
                                        <div class="flex items-center gap-1 mt-1 text-blue-600 text-xs font-bold">
                                            <span class="text-yellow-500">⭐</span> {{ $banner->button_text ?? '4.9' }} <span class="text-slate-400 font-normal">{{ $banner->card_reviews ?? "(220 Reviews)" }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="infoCard2 absolute top-24 right-4 w-80 bg-black/40 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-white/20 flex items-center gap-4 z-10">
                                    {{-- <div class="h-14 w-14 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20"> --}}
                                    <div class="h-14 w-14 rounded-xl {{$badgeClass}} items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                                        <i class="{{ $banner->tag_icon ?: 'ti ti-send' }} text-2xl"></i>
                                    </div>

                                    <div>
                                        <h4 class="text-white font-bold text-sm tracking-wide">{{ $banner->tag_heading ?? "Best Price Guarantee" }}</h4>
                                        <p class="text-slate-300 text-[11px] mt-0.5 font-normal leading-tight">{{ $banner->tag_para ?? "We ensure best price for your trips" }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev">
    </div>
    <div class="swiper-button-next">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper(".heroSlider", {
            modules: [
                SwiperModules.Navigation,
                SwiperModules.Pagination,
                SwiperModules.Autoplay,
                SwiperModules.EffectFade
            ],

            loop: true,
            speed: 1200,

            effect: "fade",

            fadeEffect: {
                crossFade: true
            },

            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true
            }
        });
    });
</script>
