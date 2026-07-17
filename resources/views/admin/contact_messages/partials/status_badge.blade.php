@php
    $badges = [
        'new' => 'secondary',
        'in_progress' => 'warning',
        'resolved' => 'success',
        'closed' => 'danger',
    ];

    $labels = [
        'new' => 'New',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ];
@endphp
<select class="form-select select2 form-select-sm changeStatus" data-id="{{ $row->id }}">
    @foreach ($labels as $value => $label)
        <option value="{{ $value }}" {{ $row->status == $value ? 'selected' : '' }} >{{ $label }}</option>
    @endforeach
</select>
