<footer class="bg-slate-950 text-white relative mt-32">

    {{-- <div class="max-w-7xl mx-auto px-6 relative -top-20 z-20">
        <div class="relative rounded-3xl overflow-hidden bg-slate-900 border border-slate-800/60 py-10 px-8 md:px-16 flex flex-col lg:flex-row lg:items-center justify-between gap-8 shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/80 to-slate-950/20 pointer-events-none z-0"></div>

            <div class="max-w-xl text-left space-y-2 relative z-10">
                <span class="text-xs font-bold text-blue-400 tracking-widest uppercase block">
                    Subscribe to Newsletter
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Get Travel Deals & Updates
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Be the first to know about exclusive offers, new destinations and travel tips.
                </p>
            </div>

            <div class="w-full lg:max-w-md relative z-10">
                <form class="relative flex items-center bg-slate-950/40 border border-slate-800 rounded-2xl p-1.5 backdrop-blur-md">
                    <input
                        type="email"
                        placeholder="Enter your email address"
                        required
                        class="w-full bg-transparent pl-4 pr-32 py-3 text-sm text-white outline-none placeholder:text-slate-500">
                    <button
                        type="submit"
                        class="absolute right-1.5 top-1.5 bottom-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 rounded-xl transition duration-200 shadow-sm">
                        Subscribe
                    </button>
                </form>
                <span class="text-[11px] text-slate-500 block mt-2 text-left pl-2">
                    No spam. Unsubscribe anytime.
                </span>
            </div>
        </div>
    </div> --}}

    <!-- Top Overlapping Newsletter CTA Banner (Exactly as seen in image_e68204.png) -->
    <div class="max-w-7xl mx-auto px-6 relative -top-20 z-20">
        <div class="relative rounded-[32px] overflow-hidden bg-cover bg-center py-12 px-10 md:px-16 flex flex-col lg:flex-row lg:items-center justify-between gap-8 shadow-2xl"
            style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.92) 20%, rgba(15, 23, 42, 0.6) 60%, rgba(15, 23, 42, 0.85)), url('{{ asset('images/footer/newsletter1.jpg') }}');">

            <!-- Left Content Text Wrapper -->
            <div class="max-w-xl text-left space-y-2.5">
                <span class="text-xs font-bold text-blue-500 tracking-widest uppercase block">
                    SUBSCRIBE TO NEWSLETTER
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    Get Travel Deals & Updates
                </h2>
                <p class="text-slate-300 text-sm leading-relaxed font-medium">
                    Be the first to know about exclusive offers, new destinations and travel tips.
                </p>
            </div>

            <!-- Right Content Input Field Form Wrapper (Matching image_e68204.png) -->
            <div class="w-full lg:max-w-xl flex flex-col items-start lg:items-end">
                <form class="relative flex w-full items-center bg-white rounded-2xl p-1 shadow-md">
                    <input
                        type="email"
                        placeholder="Enter your email address"
                        required
                        class="w-full bg-transparent pl-5 pr-36 py-4 text-sm text-slate-800 outline-none placeholder:text-slate-400 font-medium">
                    <button
                        type="submit"
                        class="absolute right-1 top-1 bottom-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-8 rounded-xl transition duration-200 shadow-sm">
                        Subscribe
                    </button>
                </form>
                <span class="text-[11px] text-slate-400/80 block mt-2 text-left lg:text-right w-full pl-2 lg:pr-2">
                    No spam. Unsubscribe anytime.
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-16 pt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 text-left">

            <div class="lg:col-span-1 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-base font-black shadow-lg shadow-blue-600/10 tracking-tighter">
                        TB
                    </div>
                    <div>
                        <h2 class="text-lg font-black tracking-tight leading-none">TravelBook</h2>
                        <span class="text-[10px] text-slate-500 font-bold tracking-widest uppercase block mt-1">
                            Explore Beyond Limits
                        </span>
                    </div>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    Your trusted travel partner for unforgettable journeys.
                </p>
                <div class="flex items-center gap-2.5 pt-2">
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-200 text-sm">
                        <i class="ti ti-brand-facebook"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-200 text-sm">
                        <i class="ti ti-brand-instagram"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-200 text-sm">
                        <i class="ti ti-brand-x"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-200 text-sm">
                        <i class="ti ti-brand-linkedin"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Company
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition duration-150">About Us</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Press Center</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Partners</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Blog</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Support
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition duration-150">Help Center</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">FAQs</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Top Destinations
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-white transition duration-150">Bali, Indonesia</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Dubai, UAE</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Maldives</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Switzerland</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Paris, France</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Contact Us
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i class="ti ti-phone text-base text-slate-500"></i>
                        <span>+1 (555) 123-4567</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i class="ti ti-mail text-base text-slate-500"></i>
                        <span class="truncate">info@travelbook.com</span>
                    </li>
                    <li class="flex items-start gap-2.5 text-slate-400">
                        <i class="ti ti-map-pin text-base text-slate-500 mt-0.5 shrink-0"></i>
                        <span class="leading-relaxed">123 Travel Street, New York, NY 10001, USA</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="border-t border-slate-900 bg-slate-950/40 relative z-10">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-500">
                © {{ date('Y') }} TravelBook. All rights reserved.
            </p>
            <div class="flex gap-5 text-xs text-slate-500">
                <a href="#" class="hover:text-slate-300 transition">Terms</a>
                <a href="#" class="hover:text-slate-300 transition">Privacy</a>
                <a href="#" class="hover:text-slate-300 transition">Cookies</a>
            </div>
        </div>
    </div>

    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="absolute right-6 bottom-16 md:bottom-20 z-30 h-10 w-10 rounded-xl bg-blue-500/10 text-blue-400 hover:bg-blue-600 hover:text-white flex items-center justify-center transition duration-200 border border-blue-500/20 shadow-md backdrop-blur-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

</footer>
