{{-- <section class="section relative -mt-12 lg:-mt-20 z-40">

    <div class="max-w-7xl mx-auto px-6">

        <div
            x-data="{ tab: 'tour' }"
            class="bg-white/95 backdrop-blur-2xl rounded-[32px] shadow-[0_25px_80px_rgba(0,0,0,0.18)] overflow-hidden">

            <!-- Tabs -->

            <div class="flex border-b">

                <button
                    @click="tab='flight'"
                    :class="tab=='flight'
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-600'"
                    class="flex-1 py-5 font-semibold transition">

                    ✈ Flights

                </button>

                <button
                    @click="tab='hotel'"
                    :class="tab=='hotel'
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-600'"
                    class="flex-1 py-5 font-semibold transition">

                    🏨 Hotels

                </button>

                <button
                    @click="tab='tour'"
                    :class="tab=='tour'
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-600'"
                    class="flex-1 py-5 font-semibold transition">

                    🌍 Tours

                </button>

            </div>

            <!-- Search -->

            <div class="grid lg:grid-cols-5 gap-6 p-8">

                <!-- Destination -->

                <div>

                    <label class="text-sm text-gray-500">
                        Destination
                    </label>

                    <select
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4">

                        <option>Bali</option>
                        <option>Paris</option>
                        <option>Dubai</option>

                    </select>

                </div>

                <!-- Check In -->

                <div>

                    <label class="text-sm text-gray-500">
                        Check In
                    </label>

                    <input
                        type="date"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4">

                </div>

                <!-- Check Out -->

                <div>

                    <label class="text-sm text-gray-500">
                        Check Out
                    </label>

                    <input
                        type="date"
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4">

                </div>

                <!-- Guests -->

                <div>

                    <label class="text-sm text-gray-500">
                        Guests
                    </label>

                    <select
                        class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-4">

                        <option>1 Adult</option>
                        <option>2 Adults</option>
                        <option>Family</option>

                    </select>

                </div>

                <!-- Button -->

                <div class="flex items-end">

                    <button
                        class="w-full rounded-xl bg-blue-600 py-4 font-semibold text-white hover:bg-blue-700 transition">

                        🔍 Search

                    </button>

                </div>

            </div>

        </div>

    </div>

</section> --}}


{{-- <section class="relative z-40 -mt-16 lg:-mt-24">
    <div class="max-w-7xl mx-auto px-6">
        <div
            x-data="{ tab:'flight' }"
            class="overflow-hidden rounded-[30px] bg-white shadow-[0_30px_80px_rgba(0,0,0,.18)]">

            <!-- Tabs -->
            <div class="grid grid-cols-3 border-b">
                <button
                    @click="tab='flight'"
                    :class="tab=='flight'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-slate-700 hover:bg-slate-50'"
                    class="py-5 font-semibold transition">
                    ✈ Flights
                </button>

                <button
                    @click="tab='hotel'"
                    :class="tab=='hotel'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-slate-700 hover:bg-slate-50'"
                    class="py-5 font-semibold transition">
                    🏨 Hotels
                </button>

                <button
                    @click="tab='tour'"
                    :class="tab=='tour'
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-slate-700 hover:bg-slate-50'"
                    class="py-5 font-semibold transition">
                    🌍 Tours
                </button>
            </div>

            <!-- ================= FLIGHT ================= -->
            <div
                x-show="tab=='flight'"
                x-transition
                class="grid gap-6 p-8 lg:grid-cols-5">

                <div>
                    <label class="text-sm text-slate-500">From</label>
                    <input type="text"
                        placeholder="Karachi"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">To</label>
                    <input type="text"
                        placeholder="Dubai"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Departure</label>
                    <input type="date"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Passengers</label>
                    <select class="mt-2 w-full rounded-xl border p-4">
                        <option>1 Adult</option>
                        <option>2 Adults</option>
                        <option>Family</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full rounded-xl bg-blue-600 py-4 font-semibold text-white">
                        Search Flight
                    </button>
                </div>

            </div>

            <!-- ================= HOTEL ================= -->
            <div
                x-show="tab=='hotel'"
                x-transition
                class="grid gap-6 p-8 lg:grid-cols-5">

                <div>
                    <label class="text-sm text-slate-500">Hotel</label>
                    <input
                        placeholder="Bali"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Check In</label>
                    <input type="date"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Check Out</label>
                    <input type="date"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Rooms</label>
                    <select class="mt-2 w-full rounded-xl border p-4">
                        <option>1 Room</option>
                        <option>2 Rooms</option>
                        <option>3 Rooms</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full rounded-xl bg-blue-600 py-4 font-semibold text-white">
                        Search Hotel
                    </button>
                </div>

            </div>

            <!-- ================= TOUR ================= -->
            <div
                x-show="tab=='tour'"
                x-transition
                class="grid gap-6 p-8 lg:grid-cols-5">

                <div>
                    <label class="text-sm text-slate-500">Destination</label>
                    <select class="mt-2 w-full rounded-xl border p-4">
                        <option>Bali</option>
                        <option>Paris</option>
                        <option>Dubai</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-slate-500">Start Date</label>
                    <input type="date"
                        class="mt-2 w-full rounded-xl border p-4">
                </div>

                <div>
                    <label class="text-sm text-slate-500">Duration</label>
                    <select class="mt-2 w-full rounded-xl border p-4">
                        <option>3 Days</option>
                        <option>5 Days</option>
                        <option>7 Days</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-slate-500">Travelers</label>
                    <select class="mt-2 w-full rounded-xl border p-4">
                        <option>2 Persons</option>
                        <option>4 Persons</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full rounded-xl bg-blue-600 py-4 font-semibold text-white">
                        Find Tour
                    </button>
                </div>

            </div>
        </div>
    </div>
</section> --}}
