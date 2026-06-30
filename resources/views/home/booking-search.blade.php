<section class="relative z-40 -mt-20 sm:-mt-24 lg:-mt-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ tab: 'flight' }" class="bg-[#f4f7fc] rounded-[24px] sm:rounded-[36px] p-4 sm:p-6 lg:p-8 shadow-[0_25px_60px_rgba(0,0,0,0.12)] border border-white">

            <div class="flex items-center space-x-6 sm:space-x-8 mb-6 border-b border-slate-200/60 pb-3 overflow-x-auto whitespace-nowrap [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <button @click="tab='flight'" :class="tab=='flight' ? 'text-blue-600 border-b-2 border-blue-600 font-bold' : 'text-slate-400 font-medium'" class="flex items-center gap-2 pb-2 transition-all shrink-0 text-sm sm:text-base">
                    <span>✈</span> Flights
                </button>
                <button @click="tab='hotel'" :class="tab=='hotel' ? 'text-blue-600 border-b-2 border-blue-600 font-bold' : 'text-slate-400 font-medium'" class="flex items-center gap-2 pb-2 transition-all shrink-0 text-sm sm:text-base">
                    <span>🏨</span> Hotels
                </button>
                <button @click="tab='tour'" :class="tab=='tour' ? 'text-blue-600 border-b-2 border-blue-600 font-bold' : 'text-slate-400 font-medium'" class="flex items-center gap-2 pb-2 transition-all shrink-0 text-sm sm:text-base">
                    <span>🗺</span> Tours
                </button>
                <button @click="tab='car'" :class="tab=='car' ? 'text-blue-600 border-b-2 border-blue-600 font-bold' : 'text-slate-400 font-medium'" class="flex items-center gap-2 pb-2 transition-all shrink-0 text-sm sm:text-base">
                    <span>🚗</span> Car Rentals
                </button>
            </div>

            <div>
                <div x-show="tab=='flight'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">
                    <div class="lg:col-span-3 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Where to?</span>
                        <input type="text" placeholder="Search destinations" class="bg-transparent text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-2 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Check In</span>
                        <input type="text" onfocus="(this.type='date')" placeholder="Add date" class="bg-transparent text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-2 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Check Out</span>
                        <input type="text" onfocus="(this.type='date')" placeholder="Add date" class="bg-transparent text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-3 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Guests</span>
                        <select class="bg-transparent text-sm font-semibold text-slate-800 focus:outline-none mt-0.5 appearance-none cursor-pointer w-full">
                            <option>2 Adults, 0 Children</option>
                            <option>1 Adult</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2 w-full col-span-1 sm:col-span-2 lg:w-auto">
                        <button class="w-full h-12 sm:h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-xl sm:rounded-2xl font-bold transition duration-200 text-sm shadow-lg shadow-blue-600/20">
                            Search
                        </button>
                    </div>
                </div>

                <div x-show="tab=='hotel'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">
                    <div class="lg:col-span-3 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Hotel / Area</span>
                        <input type="text" placeholder="Search hotels" class="bg-transparent text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-2 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Check In</span>
                        <input type="text" onfocus="(this.type='date')" placeholder="Add date" class="bg-transparent text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-2 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Check Out</span>
                        <input type="text" onfocus="(this.type='date')" placeholder="Add date" class="bg-transparent text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none mt-0.5 w-full">
                    </div>
                    <div class="lg:col-span-3 flex flex-col px-4 py-2.5 sm:px-5 sm:py-3 bg-white rounded-xl sm:rounded-2xl border border-slate-100 shadow-sm w-full">
                        <span class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-wider">Rooms</span>
                        <select class="bg-transparent text-sm font-semibold text-slate-800 focus:outline-none mt-0.5 appearance-none cursor-pointer w-full">
                            <option>1 Room, 2 Adults</option>
                        </select>
                    </div>
                    <div class="lg:col-span-2 w-full col-span-1 sm:col-span-2 lg:w-auto">
                        <button class="w-full h-12 sm:h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-xl sm:rounded-2xl font-bold transition text-sm">
                            Search
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
