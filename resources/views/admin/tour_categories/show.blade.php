<div class="row">
    <div class="col-md-4">
        <div class="text-center">
            <div
                class="rounded-circle d-inline-flex align-items-center justify-content-center shadow"
                style="
                    width:90px;
                    height:90px;
                    background:{{ $tour_category->color ?? '#696cff' }};
                ">
                <i
                    class="{{ $tour_category->icon }}"
                    style="font-size:42px;color:#fff;">
                </i>
            </div>

            <h4 class="mt-3 mb-1">
                {{ $tour_category->name }}
            </h4>

            @if($tour_category->status)
                <span class="badge bg-success">
                    Active
                </span>
            @else
                <span class="badge bg-danger">
                    Inactive
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-8">
        <table class="table table-borderless table-sm">
            <tr>
                <th width="180">Name</th>
                <td>{{ $tour_category->name }}</td>
            </tr>

            <tr>
                <th>Slug</th>
                <td>{{ $tour_category->slug }}</td>
            </tr>

            <tr>
                <th>Icon Class</th>
                <td>
                    <code>{{ $tour_category->icon }}</code>
                </td>
            </tr>

            <tr>
                <th>Color</th>
                <td>
                    <span class="badge me-2" style="
                            background:{{ $tour_category->color }};
                            width:22px; height:22px;">
                    </span>
                    {{ $tour_category->color }}
                </td>
            </tr>

            <tr>
                <th>Sort Order</th>
                <td>{{ $tour_category->sort_order }}</td>
            </tr>

            <tr>
                <th>Total Tours</th>
                <td>
                    <span class="badge bg-label-primary">
                        {{ $tour_category->tours()->count() }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Created</th>
                <td>{{ $tour_category->created_at->format('d M Y h:i A') }}</td>
            </tr>

            <tr>
                <th>Updated</th>
                <td>{{ $tour_category->updated_at->diffForHumans() }}</td>
            </tr>
        </table>
    </div>
</div>
