{{-- <section class="section relative min-h-[1150px] lg:min-h-[900px] overflow-hidden bg-[#07152d]">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero/hero-main.png') }}"
            alt="Hero"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#07152d]/95 via-[#07152d]/70 to-transparent"></div>
    </div>

    <!-- Decorative Blur -->
    <div class="absolute -top-32 -left-20 w-96 h-96 rounded-full bg-blue-500/20 blur-[120px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-cyan-500/10 blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-20 items-center min-h-[900px] pt-40 pb-20">
            <!-- LEFT -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-400/30 bg-blue-500/10 px-5 py-2 text-blue-300 text-sm">
                    🌍 Explore Beyond Limits
                </div>

                <!-- Heading -->
                <h1 class="hero-title max-w-2xl text-6xl lg:text-7xl xl:text-8xl font-extrabold tracking-tight leading-[1.02] text-white">
                    Discover Amazing
                    Places Around
                    <span class="text-blue-500">
                        The World
                    </span>
                </h1>

                <!-- Description -->
                <p class="hero-text mt-8 max-w-xl text-xl leading-9 text-slate-200">
                    Explore breathtaking destinations, luxury stays,
                    unforgettable adventures and exclusive travel packages
                    designed for modern explorers.
                </p>

                <!-- Buttons -->
                <div class="flex gap-5 mt-10">
                    <a href="#" class="px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                        Explore Tours
                    </a>

                    <a href="#" class="px-8 py-4 rounded-2xl border border-white/20 backdrop-blur text-white">
                        Learn More
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-10 mt-14">
                    <div>
                        <h2 class="text-4xl font-black text-white">
                            50K+
                        </h2>
                        <p class="text-slate-400">
                            Happy Travelers
                        </p>
                    </div>

                    <div>
                        <h2 class="text-4xl font-black text-white">
                            500+
                        </h2>
                        <p class="text-slate-400">
                            Destinations
                        </p>
                    </div>

                    <div>
                        <h2 class="text-4xl font-black text-white">
                            98%
                        </h2>
                        <p class="text-slate-400">
                            Satisfaction
                        </p>
                    </div>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="relative hidden lg:block">
                <img
                    src="{{ asset('images/hero/hero-shape.png') }}"
                    class="rounded-[40px] shadow-2xl border border-white/10">

                <!-- Floating Card -->
                <div class="absolute top-10 -left-16 w-72 bg-white rounded-3xl shadow-2xl p-5">
                    <div class="flex gap-4">
                        <img
                            src="{{ asset('images/destinations/bali.jpg') }}"
                            class="w-20 h-20 rounded-2xl object-cover">
                        <div>
                            <h3 class="font-bold text-lg">
                                Bali, Indonesia
                            </h3>

                            <p class="text-slate-500 text-sm">
                                Tropical Paradise
                            </p>

                            <div class="mt-2 font-semibold text-blue-600">
                                ⭐ 4.9 (4,200 Reviews)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Card -->

                <div class="absolute bottom-10 right-0 bg-white rounded-3xl shadow-2xl p-6">
                    <p class="text-slate-500">
                        Starting From
                    </p>

                    <h2 class="text-4xl font-black text-blue-600">
                        $799
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        7 Days Luxury Tour
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    gsap.from(".hero-title",{
        y:80,
        opacity:0,
        duration:1,
        ease:"power4.out"
    });
</script> --}}


{{-- <section class="section relative overflow-hidden bg-[#07152d] min-h-[950px] lg:min-h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero/hero-main.png') }}"
            alt="Travel Hero"
            class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#07152d]/95 via-[#07152d]/75 to-[#07152d]/30"></div>
    </div>

    <!-- Blur -->
    <div class="absolute -top-40 -left-32 h-[450px] w-[450px] rounded-full bg-blue-600/20 blur-[150px]"></div>
    <div class="absolute bottom-0 right-0 h-[500px] w-[500px] rounded-full bg-cyan-500/10 blur-[170px]"></div>
    <div class="relative z-10 mx-auto flex min-h-[950px] max-w-7xl items-center px-6 lg:px-8">
        <div class="grid w-full items-center gap-20 lg:grid-cols-2">
            <!-- LEFT -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-3 rounded-full border border-blue-400/30 bg-blue-500/10 px-5 py-2 text-sm font-semibold text-blue-300 backdrop-blur-xl">
                    🌍 Explore Beyond Limits
                </div>

                <!-- Heading -->
                <h1 class="hero-title mt-8 max-w-2xl text-6xl font-black leading-[0.95] tracking-[-2px] text-white lg:text-7xl xl:text-8xl">
                    Discover Amazing
                    <br>
                    Places Around
                    <br>
                    <span class="relative inline-block text-blue-500">
                        The World
                        <span class="absolute -bottom-2 left-0 h-1.5 w-full rounded-full bg-blue-500"></span>
                    </span>
                </h1>

                <!-- Paragraph -->
                <p class="hero-text mt-8 max-w-xl text-lg leading-9 text-slate-300">
                    Explore breathtaking destinations, luxury resorts,
                    unforgettable adventures and exclusive travel
                    experiences crafted for modern explorers.
                </p>

                <!-- Buttons -->
                <div class="hero-buttons mt-10 flex flex-wrap gap-5">
                    <a href="#"
                        class="rounded-full bg-blue-600 px-8 py-4 font-semibold text-white shadow-xl transition duration-300 hover:-translate-y-1 hover:bg-blue-700">
                        Explore Tours
                    </a>

                    <a href="#"
                        class="rounded-full border border-white/20 bg-white/5 px-8 py-4 font-semibold text-white backdrop-blur-xl transition duration-300 hover:bg-white hover:text-slate-900">
                        Watch Video
                    </a>
                </div>

                <!-- Travelers -->
                <div class="hero-stats mt-14 flex items-center gap-6">
                    <div class="flex -space-x-4">
                        <img
                            src="{{ asset('images/users/user1.png') }}"
                            class="h-14 w-14 rounded-full border-4 border-white object-cover">
                        <img
                            src="{{ asset('images/users/user2.png') }}"
                            class="h-14 w-14 rounded-full border-4 border-white object-cover">
                        <img
                            src="{{ asset('images/users/user3.png') }}"
                            class="h-14 w-14 rounded-full border-4 border-white object-cover">
                        <img
                            src="{{ asset('images/users/user4.png') }}"
                            class="h-14 w-14 rounded-full border-4 border-white object-cover">
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-white">
                            50K+
                        </h3>
                        <p class="text-slate-300">
                            Happy Travelers Worldwide
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="hero-image relative hidden lg:flex justify-center">
                <!-- Main Image -->
                <img
                    src="{{ asset('images/hero/hero-shape.png') }}"
                    class="w-[580px] rounded-[45px] border border-white/10 shadow-[0_40px_100px_rgba(0,0,0,.45)]">
                <!-- Floating Destination Card -->
                <div class="absolute -left-12 top-16 w-72 rounded-3xl bg-white/95 p-5 shadow-2xl backdrop-blur-xl">
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

                <!-- Floating Price -->
                <div class="absolute bottom-10 right-0 rounded-3xl bg-white p-6 shadow-2xl">
                    <p class="text-slate-500">
                        Starting From
                    </p>

                    <h2 class="mt-2 text-5xl font-black text-blue-600">
                        $799
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        7 Days Luxury Tour
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    gsap.from(".hero-title",{
        y:80,
        opacity:0,
        duration:1,
        ease:"power4.out"
    });
</script> --}}


{{-- <section class="relative overflow-hidden bg-[#07152d] min-h-[900px]">

    <!-- Background -->
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero/hero-main.png') }}"
            alt="Hero"
            class="w-full h-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-[#07152d]/95 via-[#07152d]/70 to-[#07152d]/30"></div>
    </div>

    <!-- Blur -->
    <div class="absolute -top-40 -left-40 w-[450px] h-[450px] rounded-full bg-blue-600/20 blur-[150px]"></div>

    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-cyan-500/10 blur-[170px]"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid lg:grid-cols-2 gap-14 items-center pt-40 pb-40">

            <!-- LEFT -->
            <div>

                <!-- Badge -->

                <div class="inline-flex items-center gap-3 rounded-full border border-blue-400/30 bg-blue-500/10 px-5 py-2 text-blue-300 backdrop-blur-xl">

                    ✈ #1 Travel Booking Platform

                </div>

                <!-- Title -->

                <h1 class="hero-title mt-8 text-6xl lg:text-7xl xl:text-8xl font-black leading-[0.95] tracking-[-3px] text-white">

                    Discover Amazing

                    <br>

                    Places Around

                    <br>

                    <span class="relative text-blue-500">

                        The World

                        <span class="absolute left-0 -bottom-3 h-[6px] w-full rounded-full bg-blue-500"></span>

                    </span>

                </h1>

                <!-- Paragraph -->

                <p class="hero-text mt-8 max-w-xl text-xl leading-9 text-slate-300">

                    Explore breathtaking destinations, luxury stays,

                    unforgettable adventures and exclusive travel

                    experiences designed for modern explorers.

                </p>

                <!-- Buttons -->

                <div class="mt-10 flex gap-5">

                    <a href="#"

                        class="rounded-full bg-blue-600 px-8 py-4 font-semibold text-white shadow-xl transition hover:-translate-y-1 hover:bg-blue-700">

                        Explore Tours

                    </a>

                    <a href="#"

                        class="rounded-full border border-white/20 bg-white/10 backdrop-blur-xl px-8 py-4 font-semibold text-white hover:bg-white hover:text-slate-900">

                        Watch Video

                    </a>

                </div>

                <!-- Travelers -->

                <div class="mt-14 flex items-center gap-6">

                    <div class="flex -space-x-4">

                        <img src="{{ asset('images/users/user1.png') }}"
                            class="w-14 h-14 rounded-full border-4 border-white object-cover">

                        <img src="{{ asset('images/users/user2.png') }}"
                            class="w-14 h-14 rounded-full border-4 border-white object-cover">

                        <img src="{{ asset('images/users/user3.png') }}"
                            class="w-14 h-14 rounded-full border-4 border-white object-cover">

                        <img src="{{ asset('images/users/user4.png') }}"
                            class="w-14 h-14 rounded-full border-4 border-white object-cover">

                    </div>

                    <div>

                        <h3 class="text-3xl font-black text-white">

                            50K+

                        </h3>

                        <p class="text-slate-300">

                            Happy Travelers

                        </p>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="relative hidden lg:flex justify-center">

                <!-- Main Image -->

                <img

                    src="{{ asset('images/hero/hero-shape.png') }}"

                    class="w-[640px] rounded-[40px] border border-white/10 shadow-[0_40px_100px_rgba(0,0,0,.45)]">

                <!-- Destination Card -->

                <div class="absolute top-12 -left-12 w-80 rounded-3xl bg-white/95 backdrop-blur-xl p-5 shadow-2xl">

                    <div class="flex gap-4">

                        <img

                            src="{{ asset('images/destinations/bali.jpg') }}"

                            class="w-20 h-20 rounded-2xl object-cover">

                        <div>

                            <h3 class="font-bold text-lg">

                                Bora Bora

                            </h3>

                            <p class="text-slate-500">

                                French Polynesia

                            </p>

                            <div class="mt-2 font-semibold text-blue-600">

                                ⭐ 4.8 (230 Reviews)

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Price Card -->

                <div class="absolute bottom-14 right-0 w-80 rounded-3xl border border-white/20 bg-white/10 backdrop-blur-2xl p-6 text-white shadow-2xl">

                    <div class="flex items-center gap-4">

                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-2xl">

                            ✈

                        </div>

                        <div>

                            <h3 class="text-2xl font-bold">

                                Best Price

                            </h3>

                            <p class="text-slate-200">

                                We ensure best price

                                for your trips.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Booking Section yahan lagega (Part 2) -->

</section> --}}
