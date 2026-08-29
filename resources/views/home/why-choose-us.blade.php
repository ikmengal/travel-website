<section class="py-16 bg-slate-50/40">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Header Text -->
        <div class="mb-10 text-left">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1">
                WHY CHOOSE US
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ \App\Models\Setting::get('why_choose_heading', 'We Make Travel Easy & Fun') }}
            </h2>
        </div>

        <!-- Features Grid Matrix -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Feature 1: Best Price Guarantee -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] flex items-start gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-50 text-blue-600 shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight">{{ \App\Models\Setting::get('why_choose_1_title', 'Best Price Guarantee') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium leading-relaxed">{{ \App\Models\Setting::get('why_choose_1_text', 'We beat any qualifying price you find online') }}</p>
                </div>
            </div>

            <!-- Feature 2: 24/7 Customer Support -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] flex items-start gap-4">
                <div class="h-12 w-12 rounded-full bg-emerald-50 text-emerald-500 shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0l6-6m-3 18c-4.97 0-9-4.03-9-9s4.03-9 9-9 9 4.03 9 9-4.03 9-9 9zM3.75 9.75a9.003 9.003 0 0013.301 7.93l-3.325-3.325a5.25 5.25 0 01-6.651-6.651L3.75 9.75z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight">{{ \App\Models\Setting::get('why_choose_2_title', '24/7 Customer Support') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium leading-relaxed">{{ \App\Models\Setting::get('why_choose_2_text', "We're here to help anytime, anywhere") }}</p>
                </div>
            </div>

            <!-- Feature 3: Secure Booking -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] flex items-start gap-4">
                <div class="h-12 w-12 rounded-full bg-purple-50 text-purple-500 shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight">{{ \App\Models\Setting::get('why_choose_3_title', 'Secure Booking') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium leading-relaxed">{{ \App\Models\Setting::get('why_choose_3_text', 'Your data is protected and 100% safe') }}</p>
                </div>
            </div>

            <!-- Feature 4: Easy & Fast Booking -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgba(15,23,42,0.01)] flex items-start gap-4">
                <div class="h-12 w-12 rounded-full bg-amber-50 text-amber-500 shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.63 8.41a14.98 14.98 0 00-6.16 12.12A14.98 14.98 0 0015.59 14.37z" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight">{{ \App\Models\Setting::get('why_choose_4_title', 'Easy & Fast Booking') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-medium leading-relaxed">{{ \App\Models\Setting::get('why_choose_4_text', 'Book in just a few clicks and enjoy your trip') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>
