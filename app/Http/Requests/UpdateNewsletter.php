<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsletter extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('newsletter-subscribers-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('newsletter_subscribers', 'email')
                    ->ignore($this->route('newsletter_subscriber')),
            ],

            'status'             => ['required', 'boolean'],
            'subscribed_at'      => ['nullable', 'date'],
            'verified_at'        => ['nullable', 'date', 'after_or_equal:subscribed_at'],
            'unsubscribed_at'    => ['nullable', 'date', 'after_or_equal:verified_at'],
            'unsubscribe_reason' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required'                  => 'Email is required.',
            'email.email'                     => 'Please enter a valid email address.',
            'email.unique'                    => 'This email is already subscribed.',
            'status.required'                 => 'Status is required.',
            'verified_at.after_or_equal'      => 'Verified date must be after subscribed date.',
            'unsubscribed_at.after_or_equal'  => 'Unsubscribed date must be after verified date.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => filter_var($this->status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
        ]);
    }
}
