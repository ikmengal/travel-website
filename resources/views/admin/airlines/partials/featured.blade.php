@can('airlines-edit')

<label class="switch switch-warning">

    <input
        type="checkbox"
        class="switch-input changeFeatured"
        data-id="{{ $row->id }}"
        {{ $row->featured ? 'checked' : '' }}>

    <span class="switch-toggle-slider">

        <span class="switch-on">
            <i class="ti ti-check"></i>
        </span>

        <span class="switch-off">
            <i class="ti ti-x"></i>
        </span>

    </span>

</label>

@else

    @if($row->featured)

        <span class="badge bg-label-warning">

            Featured

        </span>

    @else

        <span class="badge bg-label-secondary">

            No

        </span>

    @endif

@endcan
