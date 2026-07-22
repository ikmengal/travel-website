@extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)
@section('content')
<!-- Hero -->
<section class="relative bg-slate-900">
    @if($page->featured_image)
        <img src="{{ asset('images/pages/'.$page->featured_image) }}"
            class="absolute inset-0 h-full w-full object-cover opacity-30"
            alt="{{ $page->title }}">
    @endif

    <div class="relative mx-auto max-w-7xl px-6 py-24">
        <h1 class="text-4xl font-bold text-white">
            {{ $page->title }}
        </h1>
        <nav class="mt-4 flex items-center gap-2 text-gray-300">
            <a href="{{ url('/') }}" class="hover:text-white">
                Home
            </a>
            <span>/</span>
            <span class="text-white">
                {{ $page->title }}
            </span>
        </nav>
    </div>
</section>

<!-- Content -->
<section class="bg-gray-50 py-16">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid lg:grid-cols-4 gap-10">
            <!-- Left -->
            <div class="lg:col-span-3">
                @if($page->featured_image)
                    <img src="{{ asset('images/pages/'.$page->featured_image) }}"
                        class="mb-8 rounded-xl shadow-lg w-full"
                        alt="{{ $page->title }}">
                @endif
                @if($page->short_description)
                    <div class="mb-8 rounded-lg border-l-4 border-blue-600 bg-blue-50 p-6">
                        <p class="text-lg text-gray-700">
                            {{ $page->short_description }}
                        </p>
                    </div>
                @endif
                <article class="prose prose-lg max-w-none">
                    {!! $page->description !!}
                </article>
            </div>

            <!-- Sidebar -->
            <div>
                <div class="rounded-xl bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold">
                        Page Information
                    </h3>

                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between">
                            <span>Type</span>
                            <span>
                                {{ \App\Models\Page::PAGE_TYPES[$page->page_type] }}
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span>Updated</span>
                            <span>
                                {{ $page->updated_at->format('d M Y') }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
