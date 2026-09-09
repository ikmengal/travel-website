@php
    $aboutPage = \App\Models\Page::where('slug', 'about-us')->where('status', 1)->first();
    $termsPage = \App\Models\Page::where('slug', 'terms-conditions')->where('status', 1)->first();
    $privacyPage = \App\Models\Page::where('slug', 'privacy-policy')->where('status', 1)->first();
    $footerAbout = \App\Models\Setting::get('footer_about', 'Your trusted travel partner for unforgettable journeys.');
@endphp

<footer class="bg-slate-950 text-white relative mt-32">
    <!-- Top Overlapping Newsletter CTA Banner -->
    <div class="max-w-7xl mx-auto px-6 relative -top-20 z-20">
        <div class="relative rounded-[32px] overflow-hidden bg-cover bg-center py-12 px-10 md:px-16 flex flex-col lg:flex-row lg:items-center justify-between gap-8 shadow-2xl"
            style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.92) 20%, rgba(15, 23, 42, 0.6) 60%, rgba(15, 23, 42, 0.85)), url('{{ asset('images/footer/newsletter1.jpg') }}');">

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

            <div class="w-full lg:max-w-xl flex flex-col items-start lg:items-end">
                <form action="{{ route('frontend.newsletter.subscribe') }}" method="POST" class="relative flex w-full items-center bg-white rounded-2xl p-1 shadow-md">
                    @csrf
                    <input
                        type="email"
                        name="email"
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

            <!-- Brand & Social -->
            <div class="lg:col-span-1 space-y-5">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 font-bold text-white text-xl transition duration-300 hover:rotate-6 hover:scale-110">
                            TB
                        </div>
                        <div>
                            <h2 class="font-black text-2xl">TravelBook</h2>
                            <p class="text-sm text-gray-500">Explore Beyond Limits</p>
                        </div>
                    </a>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    {{ $footerAbout }}
                </p>
                <div class="flex items-center gap-2.5 pt-2">
                    @forelse($footerSocialLinks as $social)
                        <a href="{{ $social->url }}" target="{{ $social->open_in_new_tab ? '_blank' : '_self' }}" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-200 text-sm">
                            <i class="{{ $social->icon }}"></i>
                        </a>
                    @empty
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
                    @endforelse
                </div>
            </div>

            <!-- Company -->
            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Company
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    @if($aboutPage)
                        <li><a href="{{ route('main_pages.show', $aboutPage->slug) }}" class="hover:text-white transition duration-150">About Us</a></li>
                    @endif
                    <li><a href="{{ route('frontend.tours.index') }}" class="hover:text-white transition duration-150">Tours</a></li>
                    <li><a href="{{ route('frontend.hotels.index') }}" class="hover:text-white transition duration-150">Hotels</a></li>
                    <li><a href="{{ route('frontend.destinations.index') }}" class="hover:text-white transition duration-150">Destinations</a></li>
                    <li><a href="{{ route('frontend.blogs.index') }}" class="hover:text-white transition duration-150">Blog</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Support
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="{{ route('frontend.contact') }}" class="hover:text-white transition duration-150">Contact Us</a></li>
                    @if($termsPage)
                        <li><a href="{{ route('main_pages.show', $termsPage->slug) }}" class="hover:text-white transition duration-150">Terms & Conditions</a></li>
                    @endif
                    @if($privacyPage)
                        <li><a href="{{ route('main_pages.show', $privacyPage->slug) }}" class="hover:text-white transition duration-150">Privacy Policy</a></li>
                    @endif
                    @foreach($pagesMenu->take(3) as $page)
                        <li><a href="{{ route('main_pages.show', $page->slug) }}" class="hover:text-white transition duration-150">{{ $page->title }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Top Destinations -->
            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Top Destinations
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    @forelse($footerDestinations as $dest)
                        <li><a href="{{ route('frontend.destinations.show', $dest->slug) }}" class="hover:text-white transition duration-150">{{ $dest->name }}{{ $dest->country ? ', ' . $dest->country->name : '' }}</a></li>
                    @empty
                        <li><a href="{{ route('frontend.destinations.index') }}" class="hover:text-white transition duration-150">Explore Destinations</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="font-bold text-xs tracking-widest uppercase text-slate-200 mb-5">
                    Contact Us
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i class="ti ti-phone text-base text-slate-500"></i>
                        <span>{{ $contactPhone }}</span>
                    </li>
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i class="ti ti-mail text-base text-slate-500"></i>
                        <span class="truncate">{{ $contactEmail }}</span>
                    </li>
                    <li class="flex items-start gap-2.5 text-slate-400">
                        <i class="ti ti-map-pin text-base text-slate-500 mt-0.5 shrink-0"></i>
                        <span class="leading-relaxed">{{ $contactAddress }}</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="border-t border-slate-900 bg-slate-950/40 relative z-10">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-500">
                &copy; {{ date('Y') }} TravelBook. All rights reserved.
            </p>
            <div class="flex gap-5 text-xs text-slate-500">
                @if($termsPage)
                    <a href="{{ route('main_pages.show', $termsPage->slug) }}" class="hover:text-slate-300 transition">Terms</a>
                @endif
                @if($privacyPage)
                    <a href="{{ route('main_pages.show', $privacyPage->slug) }}" class="hover:text-slate-300 transition">Privacy</a>
                @endif
                <a href="{{ route('frontend.contact') }}" class="hover:text-slate-300 transition">Contact</a>
            </div>
        </div>
    </div>

    <div x-data="{ showButton: false }"
        @scroll.window="showButton = (window.pageYOffset > 300)"
        x-show="showButton"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-10"
        x-cloak
        class="fixed right-6 bottom-6 z-50">

        <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="h-10 w-10 rounded-xl bg-slate-300 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition duration-200 border border-blue-500/20 shadow-md backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </div>
</footer>
