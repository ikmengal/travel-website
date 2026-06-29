<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50">

    <div class="max-w-7xl mx-auto px-6 pt-6">

        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-xl">

            <div class="flex items-center justify-between h-20 px-8">

                <!-- Logo -->

                <a href="/" class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                        TB
                    </div>

                    <div>

                        <h2 class="font-black text-2xl">
                            TravelBook
                        </h2>

                        <p class="text-sm text-gray-500">
                            Explore Beyond Limits
                        </p>

                    </div>

                </a>

                <!-- Desktop Menu -->

                <div class="hidden lg:flex items-center gap-10">

                    <a href="#">Home</a>
                    <a href="#">Destinations</a>
                    <a href="#">Tours</a>
                    <a href="#">Hotels</a>
                    <a href="#">Blog</a>
                    <a href="#">Contact</a>

                </div>

                <!-- Desktop Buttons -->

                <div class="hidden lg:flex items-center gap-5">

                    <a href="#">
                        Login
                    </a>

                    <a href="#"
                        class="bg-blue-600 text-white px-7 py-3 rounded-2xl hover:bg-blue-700 transition">

                        Get Started

                    </a>

                </div>

                <!-- Mobile Button -->

                <button
                    @click="open=!open"
                    class="lg:hidden text-3xl">

                    ☰

                </button>

            </div>

        </div>

        <!-- Mobile Menu -->

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-5"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-5"
            @click.outside="open=false"
            class="lg:hidden mt-4 bg-white rounded-3xl shadow-xl overflow-hidden"
            x-cloak>

            <a href="#" class="block px-6 py-4 border-b">Home</a>
            <a href="#" class="block px-6 py-4 border-b">Destinations</a>
            <a href="#" class="block px-6 py-4 border-b">Tours</a>
            <a href="#" class="block px-6 py-4 border-b">Hotels</a>
            <a href="#" class="block px-6 py-4 border-b">Blog</a>
            <a href="#" class="block px-6 py-4">Contact</a>

            <div class="p-6">

                <a href="#"
                    class="block w-full text-center bg-blue-600 text-white py-4 rounded-2xl">

                    Get Started

                </a>

            </div>

        </div>

    </div>

</nav>
