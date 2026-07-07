@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    {{-- Breadcrumb --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-edit text-warning me-2"></i>
                Edit Destination
            </h4>
            <p class="text-muted mb-0">
                Update destination information and gallery.
            </p>
        </div>
        <div>
            <a href="{{ route('destinations.index') }}"
                class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <form id="destinationForm"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- LEFT SIDE --}}
            <div class="col-lg-8">

                {{-- ===================================================== --}}
                {{-- GENERAL INFORMATION --}}
                {{-- ===================================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-info-circle text-primary me-2"></i>

                            General Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-8 mb-3">

                                <label class="form-label">

                                    Destination Name

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    value="{{ old('name',$destination->name) }}"
                                    placeholder="Destination Name">

                                <span
                                    class="text-danger error"
                                    id="name_error"></span>

                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">

                                    Slug

                                </label>

                                <input
                                    type="text"
                                    id="slug"
                                    class="form-control"
                                    readonly
                                    value="{{ $destination->slug }}">

                            </div>

                            {{-- Tagline --}}
                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Tagline

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="tagline"
                                    value="{{ old('tagline',$destination->tagline) }}"
                                    placeholder="Amazing Place For Holidays">

                                <span
                                    class="text-danger error"
                                    id="tagline_error"></span>

                            </div>

                            {{-- Short Description --}}
                            <div class="col-md-12">

                                <label class="form-label">

                                    Short Description

                                </label>

                                <textarea
                                    class="form-control"
                                    rows="4"
                                    name="short_description"
                                    placeholder="Short Description">{{ old('short_description',$destination->short_description) }}</textarea>

                                <span
                                    class="text-danger error"
                                    id="short_description_error"></span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===================================================== --}}
                {{-- DESCRIPTION --}}
                {{-- ===================================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-file-description text-success me-2"></i>

                            Full Description

                        </h5>

                    </div>

                    <div class="card-body">

                        <textarea
                            id="description"
                            name="description">

                            {!! old('description',$destination->description) !!}

                        </textarea>

                        <span
                            class="text-danger error"
                            id="description_error"></span>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- LOCATION INFORMATION --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">
                            <i class="ti ti-world text-primary me-2"></i>
                            Location Information
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            {{-- Country --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Country
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="country_id"
                                    id="country_id"
                                    class="form-select select2">

                                    <option value="">Select Country</option>

                                    @foreach($countries as $country)

                                        <option value="{{ $country->id }}"
                                            {{ old('country_id',$destination->country_id)==$country->id?'selected':'' }}>

                                            {{ $country->name }}

                                        </option>

                                    @endforeach

                                </select>

                                <span class="text-danger error" id="country_id_error"></span>

                            </div>

                            {{-- State --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    State
                                </label>

                                <select
                                    name="state_id"
                                    id="state_id"
                                    class="form-select select2">

                                    <option value="">Select State</option>

                                    @foreach($states as $state)

                                        <option value="{{ $state->id }}"
                                            {{ old('state_id',$destination->state_id)==$state->id?'selected':'' }}>

                                            {{ $state->name }}

                                        </option>

                                    @endforeach

                                </select>

                                <span class="text-danger error" id="state_id_error"></span>

                            </div>

                            {{-- City --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    City
                                </label>

                                <select
                                    name="city_id"
                                    id="city_id"
                                    class="form-select select2">

                                    <option value="">Select City</option>

                                    @foreach($cities as $city)

                                        <option value="{{ $city->id }}"
                                            {{ old('city_id',$destination->city_id)==$city->id?'selected':'' }}>

                                            {{ $city->name }}

                                        </option>

                                    @endforeach

                                </select>

                                <span class="text-danger error" id="city_id_error"></span>

                            </div>

                            {{-- Starting Price --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Starting Price
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">$</span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        name="starting_price"
                                        min="0"
                                        step="0.01"
                                        value="{{ old('starting_price',$destination->starting_price) }}">

                                </div>

                                <span class="text-danger error" id="starting_price_error"></span>

                            </div>

                            {{-- Best Time --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Best Time To Visit
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="best_time_to_visit"
                                    value="{{ old('best_time_to_visit',$destination->best_time_to_visit) }}"
                                    placeholder="October - March">

                                <span class="text-danger error" id="best_time_to_visit_error"></span>

                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-4 mb-3">

                                <label class="form-label">
                                    Sort Order
                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="sort_order"
                                    value="{{ old('sort_order',$destination->sort_order) }}">

                                <span class="text-danger error" id="sort_order_error"></span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- GPS COORDINATES --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">
                            <i class="ti ti-map-pin text-danger me-2"></i>
                            GPS Coordinates
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Latitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="latitude"
                                    value="{{ old('latitude',$destination->latitude) }}">

                                <span class="text-danger error" id="latitude_error"></span>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Longitude
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="longitude"
                                    value="{{ old('longitude',$destination->longitude) }}">

                                <span class="text-danger error" id="longitude_error"></span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ===================================== --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ===================================== --}}

            <div class="col-lg-4">

                {{-- Publish --}}
                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">
                            <i class="ti ti-settings text-success me-2"></i>
                            Publish
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="status"
                                id="status"
                                value="1"
                                {{ old('status',$destination->status) ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Active
                            </label>

                        </div>

                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_featured"
                                id="is_featured"
                                value="1"
                                {{ old('is_featured',$destination->is_featured) ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Featured Destination
                            </label>

                        </div>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_popular"
                                id="is_popular"
                                value="1"
                                {{ old('is_popular',$destination->is_popular) ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Popular Destination
                            </label>

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- FEATURED IMAGE --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-photo text-primary me-2"></i>
                            Featured Image
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="text-center mb-3">

                            <img
                                id="featuredPreview"
                                src="{{ $destination->featured_image ? asset($destination->featured_image) : asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                class="img-fluid rounded shadow border"
                                style="width:100%;height:220px;object-fit:cover;">

                        </div>

                        <input
                            type="file"
                            class="form-control"
                            name="featured_image"
                            id="featured_image">

                        <span
                            id="featured_image_error"
                            class="text-danger error"></span>

                        <small class="text-muted">
                            Leave empty if you don't want to replace it.
                        </small>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- BANNER IMAGE --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">
                            <i class="ti ti-photo-plus text-info me-2"></i>
                            Banner Image
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="text-center mb-3">

                            <img
                                id="bannerPreview"
                                src="{{ $destination->banner_image ? asset($destination->banner_image) : asset('admin/assets/img/illustrations/placeholder.jpg') }}"
                                class="img-fluid rounded shadow border"
                                style="width:100%;height:220px;object-fit:cover;">

                        </div>

                        <input
                            type="file"
                            class="form-control"
                            name="banner_image"
                            id="banner_image">

                        <span
                            id="banner_image_error"
                            class="text-danger error"></span>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- DESTINATION GALLERY --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">

                            <i class="ti ti-album text-warning me-2"></i>

                            Gallery Images

                        </h5>

                        <span class="badge bg-label-primary">

                            {{ $destination->images->count() }} Images

                        </span>

                    </div>

                    <div class="card-body">

                        {{-- Existing Images --}}

                        <div class="row mb-4" id="galleryContainer">

                            @forelse($destination->images as $image)

                                <div class="col-lg-4 col-md-6 mb-3 galleryItem"
                                    id="gallery-{{ $image->id }}">

                                    <div class="card shadow-sm">

                                        <img
                                            src="{{ asset($image->image) }}"
                                            class="card-img-top"
                                            style="height:170px;object-fit:cover;">

                                        <div class="card-body p-2">

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm w-100 deleteGalleryImage"
                                                data-id="{{ $image->id }}"
                                                data-url="{{ route('destinations.gallery-image.delete',$image->id) }}">

                                                <i class="ti ti-trash me-1"></i>

                                                Delete

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-12">

                                    <div class="alert alert-warning mb-0">

                                        No Gallery Images Found.

                                    </div>

                                </div>

                            @endforelse

                        </div>

                        <hr>

                        <label class="form-label">

                            Upload More Images

                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="gallery"
                            name="gallery[]"
                            multiple>

                        <span
                            class="text-danger error"
                            id="gallery_error"></span>

                        <div
                            id="galleryPreview"
                            class="row mt-4">

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- SEO --}}
                {{-- ===================================== --}}

                <div class="card mb-4">

                    <div class="card-header">

                        <h5 class="mb-0">

                            <i class="ti ti-seo text-danger me-2"></i>

                            SEO Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Meta Title

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="meta_title"
                                value="{{ old('meta_title',$destination->meta_title) }}">

                            <span
                                class="text-danger error"
                                id="meta_title_error"></span>

                        </div>

                        <div>

                            <label class="form-label">

                                Meta Description

                            </label>

                            <textarea
                                class="form-control"
                                rows="4"
                                name="meta_description">{{ old('meta_description',$destination->meta_description) }}</textarea>

                            <span
                                class="text-danger error"
                                id="meta_description_error"></span>

                        </div>

                    </div>

                </div>

                {{-- ===================================== --}}
                {{-- ACTION BUTTONS --}}
                {{-- ===================================== --}}

                <div class="card">

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary btn-lg">

                                <i class="ti ti-device-floppy me-2"></i>

                                Update Destination

                            </button>

                            <a
                                href="{{ route('destinations.index') }}"
                                class="btn btn-label-secondary">

                                <i class="ti ti-arrow-left me-2"></i>

                                Back

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>
@endsection
@push('js')
    <script>
        $(function () {
            //=====================================================
            // SELECT2
            //=====================================================

            $('.select2').select2({
                width: '100%'
            });

            //=====================================================
            // CKEDITOR
            //=====================================================

            // ============ CKEDITOR ============ //
            if($('#description').length){
                console.log(typeof ClassicEditor);
                console.log(typeof CKEDITOR);
                CKEDITOR.replace('description');
            }

            //=====================================================
            // AUTO SLUG
            //=====================================================

            $('#name').keyup(function () {

                let slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');

                $('#slug').val(slug);

            });

            //=====================================================
            // COUNTRY -> STATES
            //=====================================================

            $('#country_id').change(function () {

                $.ajax({

                    url: "{{ route('destinations.states') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        country_id: $(this).val()
                    },

                    success: function (response) {

                        let option = '<option value="">Select State</option>';

                        $.each(response.states, function (i, item) {

                            option += `<option value="${item.id}">
                                            ${item.name}
                                    </option>`;

                        });

                        $('#state_id').html(option).trigger('change');

                        $('#city_id').html('<option value="">Select City</option>');

                    }

                });

            });

            //=====================================================
            // STATE -> CITIES
            //=====================================================

            $('#state_id').change(function () {

                $.ajax({

                    url: "{{ route('destinations.cities') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        state_id: $(this).val()
                    },

                    success: function (response) {

                        let option = '<option value="">Select City</option>';

                        $.each(response.cities, function (i, item) {

                            option += `<option value="${item.id}">
                                            ${item.name}
                                    </option>`;

                        });

                        $('#city_id').html(option);

                    }

                });

            });

            //=====================================================
            // FEATURE IMAGE PREVIEW
            //=====================================================

            $('#featured_image').change(function () {

                let reader = new FileReader();

                reader.onload = function (e) {

                    $('#featuredPreview').attr('src', e.target.result);

                }

                reader.readAsDataURL(this.files[0]);

            });

            //=====================================================
            // BANNER IMAGE PREVIEW
            //=====================================================

            $('#banner_image').change(function () {

                let reader = new FileReader();

                reader.onload = function (e) {

                    $('#bannerPreview').attr('src', e.target.result);

                }

                reader.readAsDataURL(this.files[0]);

            });

            //=====================================================
            // GALLERY PREVIEW
            //=====================================================

            $('#gallery').change(function () {

                $('#galleryPreview').html('');

                $.each(this.files, function (i, file) {

                    let reader = new FileReader();

                    reader.onload = function (e) {

                        $('#galleryPreview').append(`

                            <div class="col-lg-3 mb-3">

                                <div class="card">

                                    <img src="${e.target.result}"
                                        class="card-img-top"
                                        style="height:170px;object-fit:cover;">

                                </div>

                            </div>

                        `);

                    }

                    reader.readAsDataURL(file);

                });

            });

            //=====================================================
            // DELETE GALLERY IMAGE
            //=====================================================

            $(document).on('click', '.deleteGalleryImage', function () {

                let button = $(this);

                let url = button.data('url');

                Swal.fire({

                    title: "Delete Image?",

                    text: "This image will be removed permanently.",

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#d33",

                    cancelButtonColor: "#696cff",

                    confirmButtonText: "Delete"

                }).then((result) => {

                    if (!result.isConfirmed) return;

                    $.ajax({

                        url: url,

                        type: "DELETE",

                        data: {
                            _token: "{{ csrf_token() }}",
                            id:button.data('id')
                        },

                        success: function (response) {

                            toastr.success(response.message);

                            button.closest('.galleryItem').fadeOut(300, function () {

                                $(this).remove();

                            });

                        },

                        error: function () {

                            toastr.error("Unable to delete image.");

                        }

                    });

                });

            });

            //=====================================================
            // UPDATE DESTINATION
            //=====================================================

            $('#destinationForm').submit(function (e) {

                e.preventDefault();

                $('.error').html('');

                // if (window.descriptionEditor) {

                //     $('textarea[name=description]')
                //         .val(descriptionEditor.getData());

                // }

                CKEDITOR.instances.description.updateElement();

                let formData = new FormData(this);

                formData.set(
                  'description',
                    CKEDITOR.instances.description.getData()
                );

                let btn = $(this).find('button[type=submit]');

                btn.prop('disabled', true);

                btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');

                $.ajax({

                    url: "{{ route('destinations.update',$destination->id) }}",

                    type: "POST",

                    data: formData,

                    processData: false,

                    contentType: false,

                    success: function (response) {

                        toastr.success(response.message);

                        Swal.fire({

                            icon: "success",

                            title: "Updated",

                            text: response.message,

                            timer: 1800,

                            showConfirmButton: false

                        });

                        setTimeout(function () {

                            window.location = response.redirect;

                        }, 1800);

                    },

                    error: function (xhr) {

                        if (xhr.status == 422) {

                            $.each(xhr.responseJSON.errors, function (key, value) {

                                $('#' + key + '_error').html(value[0]);

                            });

                        } else {

                            toastr.error("Something went wrong.");

                        }

                    },

                    complete: function () {

                        btn.prop('disabled', false);

                        btn.html('<i class="ti ti-device-floppy me-2"></i>Update Destination');

                    }

                });

            });

        });
    </script>
@endpush
