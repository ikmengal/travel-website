<div>

    <h6 class="mb-1 fw-semibold">

        {{ $row->name }}

    </h6>

    <small class="text-muted">

        {{ $row->slug }}

    </small>

    <div class="mt-1">

        @if($row->email)

            <span class="badge bg-label-info">

                {{ $row->email }}

            </span>

        @endif

    </div>

</div>
