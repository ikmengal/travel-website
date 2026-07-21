@extends('admin.layouts.app')
@section('title', 'Blog Comment Details')
@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Blog Comment Details
            </h4>
            <p class="text-muted mb-0">
                View complete information about this comment.
            </p>
        </div>
        <div>
            <a href="{{ route('blog_comments.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Side --}}
        <div class="col-lg-8">
            {{-- Comment Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Comment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold d-block mb-1">Name</label>
                            <p class="mb-0">
                                {{ $blogComment->name }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold d-block mb-1">Email</label>
                            <p class="mb-0">
                                {{ $blogComment->email }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold d-block mb-1">Website</label>
                            <p class="mb-0">
                                {{ $blogComment->website ?: '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold d-block mb-1">IP Address</label>
                            <p class="mb-0">
                                {{ $blogComment->ip_address ?: '-' }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <label class="fw-semibold d-block mb-2">Comment</label>
                    <div class="border rounded p-3 bg-body">
                        {!! nl2br(e($blogComment->comment)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div class="col-lg-4">
            {{-- Comment Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Comment Details
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th width="40%">Blog</th>
                                <td>
                                    <a href="{{ route('blogs.show', $blogComment->blog_id) }}" class="fw-semibold text-primary">
                                        {{ $blogComment->blog->title ?? '-' }}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th>Type</th>
                                <td>
                                    @if($blogComment->parent_id)
                                        <span class="badge bg-label-info">Reply</span>
                                    @else
                                        <span class="badge bg-label-primary">Comment</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($blogComment->status)
                                        <span class="badge bg-label-success">Approved</span>
                                    @else
                                        <span class="badge bg-label-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Approved At</th>
                                <td>
                                    {{ optional($blogComment->approved_at)->format('d M Y h:i A') ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td>
                                    {{ $blogComment->created_at->format('d M Y h:i A') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Updated At</th>
                                <td>
                                    {{ $blogComment->updated_at->format('d M Y h:i A') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Parent Comment --}}
            @if($blogComment->parent)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Parent Comment
                        </h5>
                    </div>

                    <div class="card-body">
                        <h6 class="mb-1">
                            {{ $blogComment->parent->name }}
                        </h6>
                        <p class="text-muted mb-0">
                            {{ \Illuminate\Support\Str::limit(strip_tags($blogComment->parent->comment), 180) }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Replies --}}
            @if($blogComment->children->count())
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Replies ({{ $blogComment->children->count() }})
                        </h5>
                    </div>

                    <div class="card-body">
                        @foreach($blogComment->children as $reply)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>
                                            {{ $reply->name }}
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $reply->email }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $reply->status ? 'bg-label-success' : 'bg-label-warning' }}">
                                        {{ $reply->status ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>

                                <p class="mb-2">{{ $reply->comment }}</p>
                                <small class="text-muted">
                                    {{ $reply->created_at->format('d M Y h:i A') }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
