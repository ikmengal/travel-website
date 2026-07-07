@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="row">
    <div class="col-12">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Settings</h5>
                <a href="{{ route('settings.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Add New Setting
                </a>
            </div>

            {{-- Group Tabs --}}
            <div class="card-body pb-0">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($groups as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $group === $key ? 'active' : '' }}"
                                href="{{ route('settings.index', ['group' => $key]) }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-datatable table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Key</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Autoload</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($settings as $setting)
                            <tr>
                                <td>{{ $loop->iteration + ($settings->currentPage() - 1) * $settings->perPage() }}</td>
                                <td><code>{{ $setting->key }}</code></td>
                                <td><span class="badge bg-label-info">{{ ucfirst($setting->type) }}</span></td>
                                <td>
                                    @if ($setting->type === 'image' && $setting->value)
                                        <img src="{{ asset('storage/'.$setting->value) }}" alt="" height="30">
                                    @elseif ($setting->type === 'password')
                                        ••••••••
                                    @else
                                        {{ \Illuminate\Support\Str::limit($setting->value, 40) }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $setting->autoload ? 'success' : 'secondary' }}">
                                        {{ $setting->autoload ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input toggle-status"
                                                data-id="{{ $setting->id }}"
                                                {{ $setting->status ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('settings.edit', $setting) }}"
                                        class="btn btn-icon btn-sm btn btn-icon btn-sm btn bg-label-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('settings.destroy', $setting) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this setting?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn bg-label-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No settings found in this group.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                {{ $settings->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-status').forEach(function (el) {
                el.addEventListener('change', function () {
                    const id = this.dataset.id;
                    fetch(`/admin/settings/${id}/toggle-status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    }).catch(() => alert('Something went wrong.'));
                });
            });
        });
    </script>
@endpush
