@if($destination->featured_image)
    <img
        src="{{ asset('images/destinations/'.$destination->featured_image) }}"
        class="rounded shadow-sm" width="70" height="50" style="object-fit:cover;">
@else
    <img
        src="{{ asset('images/destinations/bali.jpg') }}"
        class="rounded" width="70" height="50">
@endif
