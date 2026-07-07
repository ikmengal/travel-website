@extends('admin.layouts.app')
@section('title', 'Add Setting')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Setting</h5>
                    <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Group</label>
                                <select name="group" class="form-select" required>
                                    @foreach ($groups as $key => $label)
                                        <option value="{{ $key }}" {{ old('group') === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <select name="type" id="typeSelect" class="form-select" required>
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Key</label>
                                <input type="text" name="key" class="form-control"
                                    placeholder="e.g. site_name" value="{{ old('key') }}" required>
                                <small class="text-muted">Unique identifier, no spaces (use underscores).</small>
                            </div>

                            <div class="col-md-6" id="valueWrapper">
                                {{-- Dynamic value field injected by JS based on type --}}
                                <label class="form-label">Value</label>
                                <input type="text" name="value" class="form-control" value="{{ old('value') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label d-block">Autoload</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="autoload" class="form-check-input" value="1" checked>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="status" class="form-check-input" value="1" checked>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Setting</button>
                            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect   = document.getElementById('typeSelect');
            const valueWrapper = document.getElementById('valueWrapper');

            function renderField(type) {
                let html = '<label class="form-label">Value</label>';

                switch (type) {
                    case 'textarea':
                        html += '<textarea name="value" rows="4" class="form-control"></textarea>';
                        break;
                    case 'number':
                        html += '<input type="number" name="value" class="form-control">';
                        break;
                    case 'email':
                        html += '<input type="email" name="value" class="form-control">';
                        break;
                    case 'url':
                        html += '<input type="url" name="value" class="form-control">';
                        break;
                    case 'image':
                        html += '<input type="file" name="value" class="form-control" accept="image/*">';
                        break;
                    case 'password':
                        html += '<input type="password" name="value" class="form-control">';
                        break;
                    case 'boolean':
                        html += '<div class="form-check form-switch"><input type="checkbox" name="value" class="form-check-input" value="1"></div>';
                        break;
                    case 'json':
                        html += '<textarea name="value" rows="4" class="form-control" placeholder=\'{"key": "value"}\'></textarea>';
                        break;
                    default:
                        html += '<input type="text" name="value" class="form-control">';
                }

                valueWrapper.innerHTML = html;
            }

            typeSelect.addEventListener('change', function () {
                renderField(this.value);
            });

            renderField(typeSelect.value);
        });
    </script>
@endpush
