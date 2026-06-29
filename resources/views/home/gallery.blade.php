<section class="py-12 sm:py-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 sm:mb-12 gap-4 sm:gap-6">
            <div class="text-left">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-1.5">
                    Our Gallery
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Explore Beautiful Places
                </h2>
                <p class="mt-2 sm:mt-3 max-w-2xl text-sm sm:text-base text-slate-500 leading-relaxed">
                    Discover breathtaking destinations and unforgettable moments from around the world.
                </p>
            </div>
            <div class="shrink-0 text-left">
                <a href="#" class="inline-flex items-center justify-center w-full sm:w-auto rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all duration-200 group">
                    View All Showcase
                    <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 sm:gap-6">

            <div class="group relative col-span-12 lg:col-span-7 h-[300px] sm:h-[400px] lg:h-[480px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                <img src="{{ asset('images/gallery/gallery1.jpg') }}" alt="Switzerland Alpine"
                    class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>

                <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 text-left flex flex-col items-start transform transition-transform duration-500 group-hover:-translate-y-1">
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 backdrop-blur-md px-2.5 py-1 text-[10px] sm:text-xs font-bold text-white border border-white/10">
                        <span class="text-blue-400">📍</span> Switzerland
                    </span>
                    <h3 class="mt-2 sm:mt-4 text-xl sm:text-3xl font-black text-white tracking-tight perfection-leading-tight">
                        Alpine Adventure
                    </h3>
                    <p class="mt-1 text-xs sm:text-sm text-slate-200/90 font-semibold tracking-wide">
                        Mountains • Nature • Luxury
                    </p>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">

                <div class="group relative h-[180px] sm:h-[200px] lg:h-[228px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                    <img src="{{ asset('images/gallery/gallery2.jpg') }}" alt="Bali Escape"
                        class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-left transform transition-transform duration-500 group-hover:-translate-y-1">
                        <span class="text-[10px] sm:text-xs font-bold text-blue-404 text-blue-400 tracking-wider uppercase block mb-0.5">📍 Bali</span>
                        <h4 class="text-lg sm:text-xl font-extrabold text-white tracking-tight">Tropical Escape</h4>
                    </div>
                </div>

                <div class="group relative h-[180px] sm:h-[200px] lg:h-[228px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                    <img src="{{ asset('images/gallery/gallery3.jpg') }}" alt="Dubai Desert"
                        class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-left transform transition-transform duration-500 group-hover:-translate-y-1">
                        <span class="text-[10px] sm:text-xs font-bold text-blue-400 tracking-wider uppercase block mb-0.5">📍 Dubai</span>
                        <h4 class="text-lg sm:text-xl font-extrabold text-white tracking-tight">Desert Luxury</h4>
                    </div>
                </div>

            </div>

            <div class="group relative col-span-12 sm:col-span-6 lg:col-span-4 h-[180px] sm:h-[220px] lg:h-[240px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                <img src="{{ asset('images/gallery/gallery4.jpg') }}" alt="Maldives View"
                    class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-left transform transition-transform duration-500 group-hover:-translate-y-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-blue-400 tracking-widest uppercase block mb-0.5">Resorts</span>
                    <h4 class="text-base sm:text-lg font-extrabold text-white tracking-tight">Maldives Islands</h4>
                </div>
            </div>

            <div class="group relative col-span-12 sm:col-span-6 lg:col-span-4 h-[180px] sm:h-[220px] lg:h-[240px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                <img src="{{ asset('images/gallery/gallery5.jpg') }}" alt="Paris Architecture"
                    class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-left transform transition-transform duration-500 group-hover:-translate-y-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-blue-400 tracking-widest uppercase block mb-0.5">Culture</span>
                    <h4 class="text-base sm:text-lg font-extrabold text-white tracking-tight">Paris Lights</h4>
                </div>
            </div>

            <div class="group relative col-span-12 sm:col-span-12 lg:col-span-4 h-[180px] sm:h-[220px] lg:h-[240px] overflow-hidden rounded-2xl shadow-[0_4px_20px_rgba(15,23,42,0.01)] transition-all duration-300 hover:shadow-xl">
                <img src="{{ asset('images/gallery/gallery6.jpg') }}" alt="Cappadocia Turkey"
                    class="h-full w-full object-cover transform duration-700 ease-out group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 text-left transform transition-transform duration-500 group-hover:-translate-y-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-blue-400 tracking-widest uppercase block mb-0.5">History</span>
                    <h4 class="text-base sm:text-lg font-extrabold text-white tracking-tight">Cappadocia Balloons</h4>
                </div>
            </div>

        </div>
    </div>
</section>
