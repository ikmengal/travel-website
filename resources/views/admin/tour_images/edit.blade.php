@extends('admin.layouts.app')
@section('title',$title)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Edit Tour Image
            </h4>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('tour_images.index') }}">
                            Tour Images
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Edit
                    </li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('tour_images.index') }}"
            class="btn btn-label-secondary">
            <i class="ti ti-arrow-left"></i>
            Back
        </a>
    </div>

    <form action="{{ route('tour_images.update',$image->id) }}" method="POST" enctype="multipart/form-data" id="tourImageForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{-------------- LEFT SIDE --------------}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Basic Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tour --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Tour</label>

                                <select name="tour_id" class="form-select select2">
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}"
                                            {{ old('tour_id',$image->tour_id)==$tour->id ? 'selected' : '' }}>
                                            {{ $tour->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Title --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Image Title</label>
                                <input type="text" name="title" value="{{ old('title',$image->title) }}" class="form-control">
                            </div>

                            {{-- Caption --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Caption</label>
                                <textarea rows="4" name="caption" class="form-control">{{ old('caption',$image->caption) }}</textarea>
                            </div>

                            {{-- Sort --}}
                            <div class="col-md-6">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$image->sort_order) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-------------- RIGHT SIDE --------------}}
            <div class="col-lg-4">
                {{-- Status --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Settings
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                {{ old('status',$image->status) ? 'checked' : '' }}>
                            <label class="form-check-label"> Active </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="featured" value="1"
                                {{ old('featured',$image->featured) ? 'checked' : '' }}>
                            <label class="form-check-label"> Featured Image </label>
                        </div>
                    </div>
                </div>

                {{-- Current Image --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Current Image
                        </h5>
                    </div>

                    <div class="card-body">
                        <img id="previewImage" src="{{ asset('images/gallery/'.$image->image) }}" class="img-fluid rounded border mb-3" style="height:250px;width:100%;object-fit:cover;">
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">

                        <small class="text-muted mt-2 d-block">
                            Leave empty if you don't want to replace the image.
                        </small>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i>
                                Update Image
                            </button>
                            <a href="{{ route('tour_images.show',$image->id) }}" class="btn btn-info">
                                <i class="ti ti-eye"></i>
                                View Image
                            </a>
                            <a href="{{ route('tour_images.index') }}" class="btn btn-outline-secondary">
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
            $('.select2').select2({
                width:'100%'
            });

            $('#image').change(function(e){
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#previewImage').attr('src',event.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endpush
