<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 px-8 py-16 lg:p-20 shadow-xl">

            <!-- Structural High-fidelity Background Blurs -->
            <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid lg:grid-cols-12 gap-12 items-center text-left">

                <!-- Left Information Column -->
                <div class="lg:col-span-7 space-y-6">
                    <span class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-xs font-bold text-white uppercase tracking-wider backdrop-blur-md border border-white/10">
                        <span>✈</span> {{ \App\Models\Setting::get('cta_eyebrow', 'Start Your Journey') }}
                    </span>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-white tracking-tight">
                        {!! \App\Models\Setting::get('cta_heading', 'Ready For Your<br>Next Adventure?') !!}
                    </h2>

                    <p class="max-w-xl text-base text-blue-100/90 leading-relaxed">
                        {{ \App\Models\Setting::get('cta_description', 'Discover breathtaking destinations, luxury stays, unforgettable experiences, and exclusive travel packages specially crafted for you.') }}
                    </p>

                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="{{ \App\Models\Setting::get('cta_button_1_url', '/tours') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-blue-700 shadow-sm hover:bg-blue-50 transition duration-200">
                            {{ \App\Models\Setting::get('cta_button_1_text', 'Explore Tours') }}
                        </a>
                        <a href="{{ \App\Models\Setting::get('cta_button_2_url', '/contact') }}" class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-md hover:bg-white/20 transition duration-200">
                            {{ \App\Models\Setting::get('cta_button_2_text', 'Contact Us') }}
                        </a>
                    </div>
                </div>

                <!-- Right Graphic Showcase Grid Column (Matching image_e60607.jpg blueprint) -->
                <div class="lg:col-span-5 relative flex items-center justify-center h-[340px] w-full select-none">

                    <!-- Outer Orbit Glass Layer -->
                    <div class="absolute h-72 w-72 rounded-full border border-white/10 bg-white/5 backdrop-blur-md flex items-center justify-center animate-[spin_120s_linear_infinite]">
                        <!-- Dashed concentric track inside -->
                        <div class="h-56 w-56 rounded-full border border-dashed border-white/20"></div>
                    </div>

                    <!-- Center Core Icon Badge -->
                    <div class="absolute h-40 w-40 rounded-full bg-gradient-to-tr from-white/20 to-white/5 backdrop-blur-lg border border-white/20 flex items-center justify-center text-5xl shadow-inner transform hover:rotate-12 transition duration-300">
                        ✈
                    </div>

                    <!-- Floating Floating Card 1: Metrics -->
                    <div class="absolute top-8 left-4 sm:left-8 rounded-2xl bg-white/95 p-4 shadow-[0_20px_40px_rgba(15,23,42,0.15)] backdrop-blur border border-slate-100 flex flex-col items-start min-w-[130px] transform -rotate-3 hover:rotate-0 transition duration-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            Happy Travelers
                        </span>
                        <h3 class="text-2xl font-black text-blue-600 tracking-tight mt-0.5">
                            50K+
                        </h3>
                    </div>

                    <!-- Floating Floating Card 2: Destinations -->
                    <div class="absolute bottom-8 right-4 sm:right-8 rounded-2xl bg-white/95 p-4 shadow-[0_20px_40px_rgba(15,23,42,0.15)] backdrop-blur border border-slate-100 flex flex-col items-start min-w-[130px] transform rotate-3 hover:rotate-0 transition duration-200">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            Destinations
                        </span>
                        <h3 class="text-2xl font-black text-indigo-600 tracking-tight mt-0.5">
                            500+
                        </h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
