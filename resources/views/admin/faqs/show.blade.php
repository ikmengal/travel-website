@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    {{------------- PAGE HEADER -------------}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti ti-eye text-info me-2"></i>
                FAQ Details
            </h4>
            <p class="text-muted mb-0">
                View complete FAQ information.
            </p>
        </div>

        <div>
            @can('faqs-edit')
                <a href="{{ route('faqs.edit',$faq->id) }}" class="btn btn-warning">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
            @endcan

            <a href="{{ route('faqs.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{------------- LEFT -------------}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        FAQ Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="220">FAQ Type</th>
                            <td>
                                <span class="badge bg-label-primary">
                                    {{ class_basename($faq->faqable_type) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Related Item</th>
                            <td>
                                {{ $faq->faqable->title ?? $faq->faqable->name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Question</th>
                            <td>
                                {{ $faq->question }}
                            </td>
                        </tr>
                        <tr>
                            <th>Answer</th>
                            <td>
                                {!! $faq->answer !!}
                            </td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>
                                {{ $faq->sort_order }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{------------- SIDEBAR -------------}}
        <div class="col-lg-4">
            {{-- Status Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Status</h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Featured</td>
                            <td class="text-end">
                                @if($faq->featured)
                                    <span class="badge bg-success">
                                        Yes
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        No
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Status
                            </td>
                            <td class="text-end">
                                @if($faq->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Information
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>ID</td>
                            <td class="text-end">#{{ $faq->id }}</td>
                        </tr>
                        <tr>
                            <td>Created</td>
                            <td class="text-end">
                                {{ $faq->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Updated</td>
                            <td class="text-end">
                                {{ $faq->updated_at->format('d M Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
