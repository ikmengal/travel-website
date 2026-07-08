@method('PUT')
<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label"> Category Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ $tour_category->name }}" placeholder="Example: Adventure Tours">
        <span class="text-danger error" id="name_error"></span>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"> Tabler Icon </label>
        <input type="text" name="icon" class="form-control"value="{{ $tour_category->icon }}" placeholder="ti ti-plane">
        <span class="text-danger error" id="icon_error"></span>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"> Color </label>
        <input type="color" name="color" class="form-control form-control-color" value="{{ $tour_category->color ?? '#696cff' }}">
        <span class="text-danger error" id="color_error"></span>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"> Sort Order </label>
        <input type="number" name="sort_order" class="form-control" value="{{ $tour_category->sort_order }}">
        <span class="text-danger error" id="sort_order_error"></span>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label"> Status </label>
        <select class="form-select" name="status">
            <option value="1"
                {{ $tour_category->status ? 'selected':'' }}>
                Active
            </option>
            <option value="0"
                {{ !$tour_category->status ? 'selected':'' }}>
                Inactive
            </option>
        </select>
        <span class="text-danger error" id="status_error"></span>
    </div>
</div>
