@extends('layouts.app')
@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8">
            Search Results
        </h2>
        @forelse($hotels as $hotel)
            <div class="bg-white rounded-xl shadow p-5 mb-5">
                <h3 class="text-xl font-bold">
                    {{ $hotel->name }}
                </h3>
                <p>
                    {{ optional($hotel->city)->name }},
                    {{ optional($hotel->country)->name }}
                </p>
                <p class="mt-2">
                    {{ $hotel->address }}
                </p>
                <a href="{{ route('hotels.show',$hotel->slug) }}"
                    class="text-blue-600 font-semibold">
                    View Details →
                </a>
            </div>
        @empty
            <div class="text-center py-20">
                No hotel found.
            </div>
        @endforelse
        {{ $hotels->links() }}
    </div>
</section>
@endsection
