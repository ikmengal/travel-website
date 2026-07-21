@if (!$row->image || !file_exists(public_path('images/banners/'.$row->image)))
    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" width="60" class="rounded">
@else
    <img src="{{ asset('images/banners/'.$row->image) }}" width="60" height="60" class="rounded object-fit-cover">';
@endif
