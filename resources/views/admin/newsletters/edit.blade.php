@extends('admin.layouts.app')
@section('title', 'Edit Newsletter Subscriber')
@section('content')
    <form id="subscriberForm" action="{{ route('newsletter_subscribers.update', $newsletter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Edit Newsletter Subscriber</h4>
                    <small class="text-muted">Update newsletter subscriber details.</small>
                </div>
                <a href="{{ route('newsletter_subscribers.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ $newsletter->email }}">
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select select2">
                            <option value="1" {{ $newsletter->status ? 'selected' : '' }}>
                                Subscribed
                            </option>
                            <option value="0" {{ !$newsletter->status ? 'selected' : '' }}>
                                Unsubscribed
                            </option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>

                    {{-- Subscribed At --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subscribed At</label>
                        <input type="datetime-local" name="subscribed_at" class="form-control"
                            value="{{ optional($newsletter->subscribed_at)->format('Y-m-d\TH:i') }}">
                        <span class="text-danger error-text subscribed_at_error"></span>
                    </div>

                    {{-- Verified At --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Verified At</label>
                        <input type="datetime-local" name="verified_at" class="form-control"
                            value="{{ optional($newsletter->verified_at)->format('Y-m-d\TH:i') }}">
                        <span class="text-danger error-text verified_at_error"></span>
                    </div>

                    {{-- Unsubscribed At --}}
                    <div class="col-md-6 mb-3 unsubscribe-fields {{ $newsletter->status ? 'd-none' : '' }}">
                        <label class="form-label">Unsubscribed At</label>
                        <input type="datetime-local" name="unsubscribed_at" class="form-control"
                            value="{{ optional($newsletter->unsubscribed_at)->format('Y-m-d\TH:i') }}">
                        <span class="text-danger error-text unsubscribed_at_error"></span>
                    </div>

                    {{-- Reason --}}
                    <div class="col-md-6 mb-3 unsubscribe-fields {{ $newsletter->status ? 'd-none' : '' }}">
                        <label class="form-label">Unsubscribe Reason</label>
                        <textarea name="unsubscribe_reason" rows="3" class="form-control">{{ $newsletter->unsubscribe_reason }}</textarea>
                        <span class="text-danger error-text unsubscribe_reason_error"></span>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i>
                    Update Subscriber
                </button>
            </div>
        </div>
    </form>
@endsection
@push('js')
    @include('admin.newsletters.partials.edit-script')
@endpush
