@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    {{------------------- Breadcrumb -------------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-map-pin me-2 text-primary"></i>
                Create Destination
            </h4>

            <p class="text-muted mb-0">
                Add a new travel destination into your booking system.
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
    <form id="destinationForm" enctype="multipart/form-data">
        @csrf
        <div class="row">

            {{------------------- LEFT SIDE -------------------}}
            <div class="col-lg-8">
                {{-------------------  GENERAL INFORMATION -------------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-info-circle text-primary me-2"></i>
                            General Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Destination Name --}}
                            <div class="col-md-8 mb-3">
                                <label class="form-label">
                                    Destination Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id="name"
                                    placeholder="Example : Dubai">

                                <span class="text-danger error" id="name_error"></span>
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Slug
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="slug"
                                    readonly>
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
                                    placeholder="Beautiful City of Dreams">
                                <span class="text-danger error"
                                    id="tagline_error"></span>
                            </div>

                            {{-- Short Description --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Short Description
                                </label>
                                <textarea
                                    rows="3"
                                    class="form-control"
                                    name="short_description"
                                    placeholder="Short introduction about destination"></textarea>
                                <span class="text-danger error"
                                    id="short_description_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{------------------- DESCRIPTION -------------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-file-description text-primary me-2"></i>
                            Full Description
                        </h5>
                    </div>

                    <div class="card-body">
                        <textarea
                            id="description"
                            name="description"></textarea>
                        <span
                            class="text-danger error"
                            id="description_error"></span>

                    </div>
                </div>

                {{------------------- LOCATION INFORMATION -------------------}}
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
                                        <option value="{{ $country->id }}">
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
                                    <option value="">
                                        Select State
                                    </option>
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
                                    <option value="">
                                        Select City
                                    </option>
                                </select>
                                <span class="text-danger error" id="city_id_error"></span>
                            </div>

                            {{-- Starting Price --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Starting Price
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        $
                                    </span>
                                    <input
                                        type="number"
                                        min="0"
                                        step="0.01"
                                        class="form-control"
                                        name="starting_price"
                                        placeholder="299">
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
                                    placeholder="October - March">
                                <span class="text-danger error"
                                    id="best_time_to_visit_error"></span>
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
                                    value="0">
                                <span class="text-danger error"
                                    id="sort_order_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{------------------- MAP COORDINATES -------------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-map-2 text-primary me-2"></i>
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
                                    placeholder="25.204849">
                                <span class="text-danger error"
                                    id="latitude_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Longitude
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="longitude"
                                    placeholder="55.270782">
                                <span class="text-danger error"
                                    id="longitude_error"></span>
                            </div>
                        </div>
                        <div class="alert alert-label-info mt-3 mb-0">
                            <i class="ti ti-map-pin me-1"></i>
                            Tip:
                            Search your destination in Google Maps and copy its latitude & longitude.
                        </div>
                    </div>
                </div>
            </div>

            {{------------------- RIGHT SIDEBAR -------------------}}
            <div class="col-lg-4">
                {{-- Publish Card --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-device-floppy text-success me-2"></i>
                            Publish
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="status"
                                name="status"
                                value="1"
                                checked>
                            <label class="form-check-label">
                                Active
                            </label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1">
                            <label class="form-check-label">
                                Featured Destination
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="is_popular"
                                name="is_popular"
                                value="1">
                            <label class="form-check-label">
                                Popular Destination
                            </label>
                        </div>
                    </div>
                </div>

                {{------------------- FEATURED IMAGE -------------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-photo text-primary me-2"></i>
                            Featured Image
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img id="featuredPreview"
                                src="{{ asset('admin/assets/img/illustrations/girl-sitting-with-laptop.png') }}"
                                class="img-fluid rounded border shadow-sm"
                                style="max-height:220px;width:100%;object-fit:cover;">
                        </div>

                        <input
                            type="file"
                            class="form-control"
                            name="featured_image"
                            id="featured_image"
                            accept="image/*">
                        <span
                            class="text-danger error"
                            id="featured_image_error"></span>
                        <small class="text-muted">
                            Recommended Size : 1200 × 700px
                        </small>
                    </div>
                </div>

                {{------------------- BANNER IMAGE -------------------}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="ti ti-photo-plus text-info me-2"></i>
                            Banner Image
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img id="bannerPreview"
                                src="{{ asset('admin/assets/img/illustrations/girl-with-laptop-light.png') }}"
                                class="img-fluid rounded border shadow-sm"
                                style="max-height:220px;width:100%;object-fit:cover;">
                        </div>
                        <input
                            type="file"
                            class="form-control"
                            name="banner_image"
                            id="banner_image"
                            accept="image/*">
                        <span
                            class="text-danger error"
                            id="banner_image_error"></span>
                        <small class="text-muted">
                            Recommended Size : 1920 × 500px
                        </small>
                    </div>
                </div>

                {{------------------- DESTINATION GALLERY -------------------}}
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-album text-warning me-2"></i>
                            Destination Gallery
                        </h5>
                        <span class="badge bg-label-primary">
                            Multiple Images
                        </span>
                    </div>

                    <div class="card-body">
                        <input
                            type="file"
                            name="gallery[]"
                            id="gallery"
                            class="form-control"
                            multiple
                            accept="image/*">

                        <span
                            class="text-danger error"
                            id="gallery_error"></span>
                        <div
                            id="galleryPreview"
                            class="row mt-4">
                        </div>
                    </div>
                </div>

                {{------------------- SEO -------------------}}
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
                                placeholder="SEO Title">
                            <span
                                class="text-danger error"
                                id="meta_title_error"></span>
                        </div>

                        <div>
                            <label class="form-label">
                                Meta Description
                            </label>
                            <textarea
                                rows="3"
                                class="form-control"
                                name="meta_description"
                                placeholder="SEO Description"></textarea>
                            <span
                                class="text-danger error"
                                id="meta_description_error"></span>
                        </div>
                    </div>
                </div>

                {{------------------- ACTION BUTTONS -------------------}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg">
                                <i class="ti ti-device-floppy me-2"></i>
                                Save Destination
                            </button>

                            <button
                                type="reset"
                                class="btn btn-label-secondary">
                                <i class="ti ti-refresh me-2"></i>
                                Reset Form
                            </button>

                            <a href="{{ route('destinations.index') }}"
                                class="btn btn-label-danger">
                                <i class="ti ti-x me-2"></i>
                                Cancel
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
    $(function(){
        // ------------------- SELECT2 ------------------- //
        $('.select2').select2({
            width:'100%'
        });

        // ------------------- CKEDITOR ------------------- //
        if($('#description').length){
            CKEDITOR.replace('description');
        }

        // ------------------- SLUG ------------------- //
        $('#name').keyup(function(){
            let slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g,'-')
                .replace(/(^-|-$)/g,'');
            $('#slug').val(slug);
        });

        // ------------------- COUNTRY -> STATE ------------------- //
        $('#country_id').change(function(){
            let country_id=$(this).val();
            $('#state_id').html('<option value="">Loading...</option>');
            $('#city_id').html('<option value="">Select City</option>');

            $.ajax({
                url:"{{ route('destinations.states') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    country_id:country_id
                },
                success:function(res){
                    let html='<option value="">Select State</option>';
                    $.each(res.states,function(i,v){
                        html+=`<option value="${v.id}">
                                ${v.name}
                            </option>`;
                    });
                    $('#state_id').html(html);
                }
            });
        });

        // ------------------- STATE -> CITY ------------------- //
        $('#state_id').change(function(){
            let state_id=$(this).val();
            $('#city_id').html('<option>Loading...</option>');

            $.ajax({
                url:"{{ route('destinations.cities') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    state_id:state_id
                },
                success:function(res){
                    let html='<option value="">Select City</option>';
                    $.each(res.cities,function(i,v){
                        html+=`<option value="${v.id}">
                                ${v.name}
                            </option>`;
                    });
                    $('#city_id').html(html);
                }
            });
        });

        // ------------------- FEATURED IMAGE PREVIEW ------------------- //
        $('#featured_image').change(function(e){
            let reader=new FileReader();
            reader.onload=function(e){
                $('#featuredPreview').attr('src',e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // ------------------- BANNER IMAGE PREVIEW ------------------- //
        $('#banner_image').change(function(e){
            let reader=new FileReader();
            reader.onload=function(e){
                $('#bannerPreview').attr('src',e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // ------------------- GALLERY PREVIEW ------------------- //
        $('#gallery').change(function(){
            $('#galleryPreview').html('');
            $.each(this.files,function(index,file){
                let reader=new FileReader();
                reader.onload=function(e){
                    $('#galleryPreview').append(`
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card">
                                <img src="${e.target.result}"
                                    class="card-img-top"
                                    style="height:180px;object-fit:cover;">
                            </div>
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            });
        });

        // ------------------- SUBMIT ------------------- //
        $('#destinationForm').submit(function(e){
            e.preventDefault();
            $('.error').html('');

            CKEDITOR.instances.description.updateElement();

            let formData=new FormData(this);

            formData.set(
                'description',
                CKEDITOR.instances.description.getData()
            );

            let btn=$(this).find('button[type=submit]');
            btn.prop('disabled',true);
            btn.html('<span class="spinner-border spinner-border-sm"></span> Saving...');

            $.ajax({
                url:"{{ route('destinations.store') }}",
                type:"POST",
                data:formData,
                processData:false,
                contentType:false,
                success:function(response){
                    toastr.success(response.message);
                    Swal.fire({
                        icon:'success',
                        title:'Success',
                        text:response.message,
                        timer:1800,
                        showConfirmButton:false
                    });
                    setTimeout(function(){
                        window.location=response.redirect;
                    },1800);
                },
                error:function(xhr){
                    btn.prop('disabled',false);
                    btn.html('<i class="ti ti-device-floppy"></i> Save Destination');
                    if(xhr.status==422){
                        $.each(xhr.responseJSON.errors,function(key,value){
                            $('#'+key+'_error').html(value[0]);
                        });
                    }else{
                        toastr.error("Something went wrong.");
                    }
                },
                complete:function(){
                    btn.prop('disabled',false);
                    btn.html('<i class="ti ti-device-floppy"></i> Save Destination');
                }
            });
        });
    });
</script>
@endpush
