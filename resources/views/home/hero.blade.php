<section class="relative min-h-[900px] flex flex-col justify-between overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/hero/hero-main.png') }}"
            alt="Mountains and Lake Reflection"
            class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.05) 100%);"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-18 z-20 my-auto">
        <div class="grid lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 flex flex-col items-start space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/40 backdrop-blur-md px-4 py-2 border border-white/10 text-white text-xs font-medium tracking-wide uppercase">
                    <span class="text-blue-400 text-sm">✈</span> #1 Travel Booking Platform
                </div>

                <h1 class="hero-title text-5xl sm:text-6xl xl:text-7xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Discover Amazing <br>
                    Places Around <br>
                    The <span class="text-blue-500">World</span>
                </h1>

                <p class="hero-text max-w-xl text-base sm:text-lg text-slate-100 font-normal leading-relaxed drop-shadow-sm">
                    Explore breathtaking destinations, luxury stays, unforgettable experiences, and exclusive travel packages designed for modern explorers.
                </p>

                <div class="flex items-center gap-3 pt-2">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=100" alt="User">
                    </div>
                    <div>
                        <div class="text-white font-bold text-base leading-none">50K+</div>
                        <div class="text-slate-200 text-xs mt-0.5">Happy Travelers</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative w-full h-[380px] hidden lg:block">
                <div class="absolute top-0 right-4 w-80 bg-white p-3 rounded-2xl shadow-xl flex items-center gap-4 z-10">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&q=80&w=150" class="w-16 h-16 rounded-xl object-cover" alt="Bali">
                    <div>
                        <h4 class="text-slate-800 font-bold text-sm">Bali, Indonesia</h4>
                        <p class="text-slate-400 text-xs">French Polynesia</p>
                        <div class="flex items-center gap-1 mt-1 text-blue-600 text-xs font-bold">
                            <span class="text-yellow-500">⭐</span> 4.9 <span class="text-slate-400 font-normal">(220 Reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="absolute top-24 right-4 w-80 bg-black/40 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-white/20 flex items-center gap-4 z-10">
                    <div class="h-14 w-14 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 transform rotate-45 -translate-x-0.5 translate-y-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-sm tracking-wide">Best Price Guarantee</h4>
                        <p class="text-slate-300 text-[11px] mt-0.5 font-normal leading-tight">We ensure best price for your trips</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <section class="relative min-h-[900px] flex flex-col justify-between overflow-hidden bg-[#031129]">
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/hero/hero-main.png') }}"
            alt="Mountains and Lake Reflection"
            class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#07152d]/95 via-[#07152d]/70 to-transparent"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-18 z-20 my-auto">
        <div class="grid lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 flex flex-col items-start space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/40 backdrop-blur-md px-4 py-2 border border-white/10 text-white text-xs font-medium tracking-wide uppercase">
                    <span class="text-blue-400 text-sm">✈</span> #1 Travel Booking Platform
                </div>

                <h1 class="hero-title text-5xl sm:text-6xl xl:text-7xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Discover Amazing <br>
                    Places Around <br>
                    The <span class="text-blue-500">World</span>
                </h1>

                <p class="hero-text max-w-xl text-base sm:text-lg text-slate-100 font-normal leading-relaxed drop-shadow-sm">
                    Explore breathtaking destinations, luxury stays, unforgettable experiences, and exclusive travel packages designed for modern explorers.
                </p>

                <div class="flex items-center gap-3 pt-2">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=100" alt="User">
                        <img class="inline-block h-9 w-9 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=100" alt="User">
                    </div>
                    <div>
                        <div class="text-white font-bold text-base leading-none">50K+</div>
                        <div class="text-slate-200 text-xs mt-0.5">Happy Travelers</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative w-full h-[380px] hidden lg:block">
                <img src="{{ asset('images/hero/hero-shape.png') }}"
                    class="w-[580px] rounded-[45px] border border-white/10 shadow-[0_40px_100px_rgba(0,0,0,.45)]">
                <div class="absolute -left-10 -top-15 w-80 rounded-3xl bg-white/95 p-5 shadow-2xl backdrop-blur-xl">
                    <div class="flex gap-4">
                        <img
                            src="{{ asset('images/destinations/bali.jpg') }}"
                            class="h-20 w-20 rounded-2xl object-cover">
                        <div>
                            <h3 class="font-bold text-slate-900">
                                Bali, Indonesia
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Tropical Paradise
                            </p>
                            <div class="mt-2 font-semibold text-blue-600">
                                ⭐ 4.9 (4,200 Reviews)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 -right-15 rounded-3xl bg-white p-6 shadow-2xl">
                    <p class="text-slate-500">
                        Starting From
                    </p>
                    <h2 class="text-2xl font-black text-blue-600">
                        $799
                    </h2>
                    <p class="text-sm text-slate-500">
                        7 Days Luxury Tour
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}
