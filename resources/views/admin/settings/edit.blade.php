@extends('admin.layouts.app')
@section('title', 'Edit Setting')
@section('content')
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Setting: <code>{{ $setting->key }}</code></h5>
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

                <form action="{{ route('settings.update', $setting) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select name="group" class="form-select" required>
                                @foreach ($groups as $key => $label)
                                    <option value="{{ $key }}" {{ $setting->group === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select name="type" id="typeSelect" class="form-select" required>
                                @foreach ($types as $key => $label)
                                    <option value="{{ $key }}" {{ $setting->type === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Key</label>
                            <input type="text" name="key" class="form-control"
                                    value="{{ old('key', $setting->key) }}" required>
                        </div>

                        <div class="col-md-6" id="valueWrapper">
                            <label class="form-label">Value</label>

                            @if ($setting->type === 'image')
                                @if ($setting->value)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$setting->value) }}" height="50" alt="">
                                    </div>
                                @endif
                                <input type="file" name="value" class="form-control" accept="image/*">
                            @elseif ($setting->type === 'textarea' || $setting->type === 'json')
                                <textarea name="value" rows="4" class="form-control">{{ old('value', $setting->value) }}</textarea>
                            @elseif ($setting->type === 'boolean')
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="value" class="form-check-input" value="1"
                                            {{ $setting->value ? 'checked' : '' }}>
                                </div>
                            @else
                                <input type="{{ $setting->type === 'password' ? 'password' : ($setting->type === 'number' ? 'number' : ($setting->type === 'email' ? 'email' : ($setting->type === 'url' ? 'url' : 'text'))) }}"
                                        name="value" class="form-control" value="{{ old('value', $setting->value) }}">
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label class="form-label d-block">Autoload</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="autoload" class="form-check-input" value="1"
                                        {{ $setting->autoload ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" class="form-check-input" value="1"
                                        {{ $setting->status ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Setting</button>
                        <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
