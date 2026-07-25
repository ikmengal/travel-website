<div class="row">

    {{-- Left Side --}}
    <div class="col-lg-8">

        <div class="card mb-4">

            <div class="card-header">

                <h5 class="card-title mb-0">

                    Flight Class Information

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Name <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name',$flightClass->name ?? '') }}"
                            placeholder="Economy">

                        <div class="invalid-feedback name_error"></div>

                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Slug <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="slug"
                            id="slug"
                            class="form-control"
                            value="{{ old('slug',$flightClass->slug ?? '') }}"
                            placeholder="economy">

                        <div class="invalid-feedback slug_error"></div>

                    </div>

                    {{-- Baggage --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Baggage (Kg)

                        </label>

                        <input
                            type="number"
                            name="baggage"
                            class="form-control"
                            min="0"
                            value="{{ old('baggage',$flightClass->baggage ?? 20) }}">

                        <div class="invalid-feedback baggage_error"></div>

                    </div>

                    {{-- Seat Priority --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Seat Priority

                        </label>

                        <input
                            type="number"
                            name="seat_priority"
                            class="form-control"
                            min="1"
                            value="{{ old('seat_priority',$flightClass->seat_priority ?? 1) }}">

                        <div class="invalid-feedback seat_priority_error"></div>

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
                            class="form-control">{{ old('description',$flightClass->description ?? '') }}</textarea>

                        <div class="invalid-feedback description_error"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Right --}}
    <div class="col-lg-4">

        {{-- Publish --}}
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="card-title mb-0">

                    Publish

                </h5>

            </div>

            <div class="card-body">

                {{-- Meal --}}
                <label class="switch switch-success mb-3">

                    <input
                        type="hidden"
                        name="meal"
                        value="0">

                    <input
                        type="checkbox"
                        name="meal"
                        value="1"
                        class="switch-input"
                        {{ old('meal',$flightClass->meal ?? false) ? 'checked' : '' }}>

                    <span class="switch-toggle-slider">

                        <span class="switch-on">
                            <i class="ti ti-check"></i>
                        </span>

                        <span class="switch-off">
                            <i class="ti ti-x"></i>
                        </span>

                    </span>

                    <span class="switch-label">

                        Meal Available

                    </span>

                </label>

                {{-- Refundable --}}
                <label class="switch switch-info mb-3">

                    <input
                        type="hidden"
                        name="refundable"
                        value="0">

                    <input
                        type="checkbox"
                        name="refundable"
                        value="1"
                        class="switch-input"
                        {{ old('refundable',$flightClass->refundable ?? false) ? 'checked' : '' }}>

                    <span class="switch-toggle-slider">

                        <span class="switch-on">
                            <i class="ti ti-check"></i>
                        </span>

                        <span class="switch-off">
                            <i class="ti ti-x"></i>
                        </span>

                    </span>

                    <span class="switch-label">

                        Refundable

                    </span>

                </label>

                {{-- Status --}}
                <label class="switch switch-primary mb-4">

                    <input
                        type="hidden"
                        name="status"
                        value="0"
                        {{ old('status',$flightClass->status ?? true) ? 'checked' : '' }}>

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        checked
                        class="switch-input">

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

                {{-- Sort Order --}}
                <div class="mb-4">

                    <label class="form-label">

                        Sort Order

                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        value="0"
                        class="form-control"
                        value="{{ old('sort_order',$flightClass->sort_order ?? 0) }}">

                </div>

                <button
                    type="submit"
                    id="submitBtn"
                    class="btn btn-primary w-100">

                    <i class="ti ti-device-floppy me-1"></i>
                    {{ isset($flightClass) && !empty($flightClass) ? 'Update Flight Class' : 'Save Flight Class' }}
                </button>

            </div>

        </div>

    </div>

</div>
