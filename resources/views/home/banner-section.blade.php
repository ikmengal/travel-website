<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-[24px] sm:rounded-[28px] overflow-hidden bg-[#06122d] bg-cover bg-center bg-no-repeat py-8 px-5 sm:px-10 shadow-xl" style="background-image: linear-gradient(to right, rgba(17, 29, 58, 0.95), rgba(15, 41, 100, 0.85)), url('{{ asset('images/hero/hero-main.png') }}');">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-y-8 gap-x-4 relative z-10 items-center divide-y lg:divide-y-0 lg:divide-x divide-white/10">
                @if (isset($counters) && !blank($counters))
                    @foreach ($counters as $key => $counter)
                        @php
                            $badgeClasses = [
                                'bg-blue-500/10 backdrop-blur-md border border-blue-500/20 text-blue-400',
                                'bg-cyan-500/10 backdrop-blur-md border border-cyan-500/20 text-cyan-400',
                                'bg-purple-500/10 backdrop-blur-md border border-purple-500/20 text-purple-400',
                                'bg-amber-500/10 backdrop-blur-md border border-amber-500/20 text-amber-400',
                            ];
                            $badgeClass = $badgeClasses[$key];
                        @endphp
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 pb-4 sm:pb-0">
                            <div class="h-11 w-11 sm:h-14 sm:w-14 rounded-xl sm:rounded-2xl {{$badgeClass}} shrink-0 flex items-center justify-center">
                                <i class="{{ $counter->icon ?: 'ti ti-send' }} text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl sm:text-3xl font-black text-white tracking-tight leading-none">{{ $counter->number ?? 0 }}{{ $counter->suffix ?? 'K+' }}</h4>
                                <p class="text-[11px] sm:text-xs text-slate-400 font-medium mt-1 sm:mt-1.5">{{ $counter->title ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
