@php
    $image = $row->featured_image
        ? asset($row->featured_image)
        : asset('admin/assets/img/avatars/1.png');
@endphp
<img src="{{ $image }}" class="rounded" width="60" height="60" style="object-fit:cover;">
