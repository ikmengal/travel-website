<div class="row">

    {{-- Left Side --}}
    <div class="col-lg-8">

        <div class="card mb-4">

            <div class="card-header">

                <h5 class="card-title mb-0">

                    Airline Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Airline Name
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name',$airline->name ?? '') }}"
                            placeholder="Emirates Airline">

                        <div class="invalid-feedback name_error"></div>

                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Slug
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="slug"
                            id="slug"
                            class="form-control"
                            value="{{ old('slug',$airline->slug ?? '') }}">

                        <div class="invalid-feedback slug_error"></div>

                    </div>

                    {{-- IATA --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            IATA Code

                        </label>

                        <input
                            type="text"
                            name="iata_code"
                            maxlength="2"
                            class="form-control"
                            value="{{ old('iata_code',$airline->iata_code ?? '') }}">

                        <div class="invalid-feedback iata_code_error"></div>

                    </div>

                    {{-- ICAO --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            ICAO Code

                        </label>

                        <input
                            type="text"
                            name="icao_code"
                            maxlength="3"
                            class="form-control"
                            value="{{ old('icao_code',$airline->icao_code ?? '') }}">

                        <div class="invalid-feedback icao_code_error"></div>

                    </div>

                    {{-- Airline Code --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Airline Code
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="airline_code"
                            class="form-control"
                            value="{{ old('airline_code',$airline->airline_code ?? '') }}">

                        <div class="invalid-feedback airline_code_error"></div>

                    </div>

                    {{-- Website --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Website

                        </label>

                        <input
                            type="url"
                            name="website"
                            class="form-control"
                            value="{{ old('website',$airline->website ?? '') }}">

                        <div class="invalid-feedback website_error"></div>

                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email',$airline->email ?? '') }}">

                        <div class="invalid-feedback email_error"></div>

                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Phone

                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone',$airline->phone ?? '') }}">

                        <div class="invalid-feedback phone_error"></div>

                    </div>

                    {{-- Sort --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order',$airline->sort_order ?? 0) }}">

                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="8"
                            class="form-control">{{ old('description',$airline->description ?? '') }}</textarea>

                        <div class="invalid-feedback description_error"></div>

                    </div>

                    {{-- Meta Title --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">

                            Meta Title

                        </label>

                        <input
                            type="text"
                            name="meta_title"
                            class="form-control"
                            value="{{ old('meta_title',$airline->meta_title ?? '') }}">

                    </div>

                    {{-- Meta Description --}}
                    <div class="col-md-12">

                        <label class="form-label">

                            Meta Description

                        </label>

                        <textarea
                            name="meta_description"
                            rows="4"
                            class="form-control">{{ old('meta_description',$airline->meta_description ?? '') }}</textarea>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Right Sidebar --}}
    <div class="col-lg-4">

        {{-- Logo --}}
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    Airline Logo

                </h5>

            </div>

            <div class="card-body">

                <input
                    type="file"
                    name="logo"
                    id="logo"
                    class="form-control"
                    accept="image/*">

                <div class="invalid-feedback logo_error"></div>

                <div class="mt-3 text-center">

                    <img
                        id="logoPreview"
                        src="{{ isset($airline) && $airline->logo
                                ? asset('images/airlines/'.$airline->logo)
                                : asset('admin/assets/img/placeholder.jpg') }}"
                        class="img-fluid rounded border"
                        style="max-height:220px;">

                </div>

            </div>

        </div>

        {{-- Options --}}
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    Options

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <label class="switch switch-warning">

                        <input
                            type="hidden"
                            name="featured"
                            value="0">

                        <input
                            type="checkbox"
                            name="featured"
                            value="1"
                            class="switch-input"
                            {{ old('featured',$airline->featured ?? 0) ? 'checked' : '' }}>

                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="ti ti-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="ti ti-x"></i>
                            </span>
                        </span>

                        <span class="switch-label">
                            Featured
                        </span>

                    </label>

                </div>

                <div>

                    <label class="switch switch-success">

                        <input
                            type="hidden"
                            name="status"
                            value="0">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            class="switch-input"
                            {{ old('status',$airline->status ?? 1) ? 'checked' : '' }}>

                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="ti ti-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="ti ti-x"></i>
                            </span>
                        </span>

                        <span class="switch-label">
                            Active
                        </span>

                    </label>

                </div>

            </div>

        </div>

        {{-- Publish --}}
        <div class="card">

            <div class="card-body">

                <div class="d-grid">

                    <button
                        type="submit"
                        id="submitBtn"
                        class="btn btn-primary">

                        <i class="ti ti-device-floppy me-1"></i>

                        {{ isset($airline) ? 'Update Airline' : 'Save Airline' }}

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
