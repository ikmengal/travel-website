<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">

            <!-- Left Sticky Sidebar Content Block -->
            <div class="lg:col-span-5 lg:sticky lg:top-8 text-left">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block mb-3">
                    Support Hub
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    Frequently Asked Questions
                </h2>
                <p class="mt-4 text-base text-slate-500 leading-relaxed max-w-md">
                    Find clear, straightforward answers to the most common queries regarding booking processes, flexible payments, and cancellations.
                </p>
                <div class="mt-8">
                    <a href="#" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition duration-200 group">
                        Contact Support
                        <span class="ml-2 transform group-hover:translate-x-1 transition-transform duration-200">→</span>
                    </a>
                </div>
            </div>

            <!-- Right Interactive Accordion Wrapper -->
            <div class="lg:col-span-7 space-y-4">
                @if (isset($databaseFaqs) && !blank($databaseFaqs))
                    @foreach($databaseFaqs as $faq)
                        <div x-data="{ open: false }"
                            class="rounded-2xl bg-white border border-slate-100 shadow-[0_4px_25px_rgba(15,23,42,0.02)] transition duration-200 overflow-hidden"
                            :class="open ? 'border-blue-100 shadow-[0_10px_30px_rgba(37,99,235,0.04)]' : ''">

                            <!-- Accordion Trigger Button -->
                            <button @click="open = !open"
                                    type="button"
                                    class="flex w-full items-center justify-between p-6 text-left transition duration-150 outline-none select-none">
                                <h3 class="font-bold text-base text-slate-900 pr-4 transition duration-150"
                                    :class="open ? 'text-blue-600' : 'text-slate-900'">
                                    {{ $faq['question'] }}
                                </h3>

                                <!-- Premium Smooth Rotating SVG Caret Icon -->
                                <span class="h-6 w-6 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 shrink-0 transform transition-transform duration-200"
                                    :class="open ? 'rotate-180 bg-blue-50 text-blue-600' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Animated Collapse Content Wrapper -->
                            <div x-show="open"
                                x-collapse
                                x-cloak>
                                <div class="px-6 pb-6 text-sm text-slate-500 leading-relaxed border-t border-slate-50/50 pt-3 text-left">
                                    {!! $faq['answer'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
