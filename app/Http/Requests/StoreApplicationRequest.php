<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isApplicant();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'category'    => 'required|in:leave,expense,procurement,reimbursement,other',
            'description' => 'required|string|min:10',
            'amount'      => 'nullable|numeric|min:0|max:99999999.99',
            'date'        => 'nullable|date',
            'attachment'  => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png', // 5MB max
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'description.min' => 'Description must be at least 10 characters long.',
            'attachment.max'  => 'Attachment must not be larger than 5MB.',
        ];
    }
}