<div class="row">

    {{-- Name --}}
    <div class="col-md-8 mb-3">
        <label class="form-label">
            Category Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            placeholder="e.g. Adventure Tours">

        <small class="text-muted">
            Example: Adventure Tours, Family Tours, Honeymoon Tours
        </small>

        <span class="text-danger error" id="name_error"></span>
    </div>

    {{-- Sort Order --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">
            Sort Order
        </label>

        <input
            type="number"
            class="form-control"
            id="sort_order"
            name="sort_order"
            value="0"
            min="0"
            placeholder="0">

        <small class="text-muted">
            Smaller number appears first.
        </small>

        <span class="text-danger error" id="sort_order_error"></span>
    </div>

</div>

<div class="row">

    {{-- Icon --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Icon
        </label>

        <input
            type="text"
            class="form-control"
            id="icon"
            name="icon"
            placeholder="e.g. ti ti-mountain">

        <small class="text-muted">
            Tabler Icon Class (Example: ti ti-plane, ti ti-map, ti ti-beach)
        </small>

        <span class="text-danger error" id="icon_error"></span>

    </div>

    {{-- Color --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">
            Badge Color
        </label>

        <input
            type="color"
            class="form-control form-control-color"
            id="color"
            name="color"
            value="#696cff">

        <small class="text-muted">
            Choose category badge color.
        </small>

        <span class="text-danger error" id="color_error"></span>

    </div>

</div>

<div class="row">

    {{-- Status --}}
    <div class="col-md-12">

        <label class="form-label d-block">
            Status
        </label>

        <div class="form-check form-switch">

            <input
                class="form-check-input"
                type="checkbox"
                id="status"
                name="status"
                value="1"
                checked>

            <label class="form-check-label">
                Active Category
            </label>

        </div>

        <small class="text-muted">
            Disable if you don't want to show this category.
        </small>

        <span class="text-danger error" id="status_error"></span>

    </div>

</div>

<script>
    $('select').each(function() {
        $(this).select2({
            dropdownParent: $(this).parent(),
        });
    });

    $('#icon').on('keyup',function(){
        let icon=$(this).val();
        $('#iconPreview').remove();
        if(icon!='')
        {
            $(this).after(
                '<div id="iconPreview" class="mt-3">'+
                '<i class="'+icon+' fs-1 text-primary"></i>'+
                '</div>'
            );
        }
    });
</script>
