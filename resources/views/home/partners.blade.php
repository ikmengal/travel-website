<section class="relative bg-[#f8fafc] py-8 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main White Container Wrapper -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 items-center justify-items-center divide-x-0 lg:divide-x divide-slate-100">
                @if (isset($partners) && !blank($partners))
                    @foreach ($partners as $partner)
                         <div class="w-full flex items-center justify-center lg:px-4 opacity-60 hover:opacity-100 transition duration-300">
                            <div class="flex items-center gap-1">
                                @if(!empty($partner->logo))
                                    <img src="{{ $partner->logo }}" alt="{{ $partner->name }}"
                                        class="h-10 w-auto object-contain" loading="lazy">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center">
                                        🏢
                                    </div>
                                @endif
                                <span class="font-bold text-slate-700">
                                    {{ $partner->name }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full flex items-center justify-center lg:px-4 opacity-60 hover:opacity-100 transition duration-300">
                        <span class="font-semibold text-lg tracking-tight text-slate-700 flex items-center gap-1">
                            🏢 <span class="font-bold">Expedia</span>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
