<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewActionRequest extends FormRequest
{
    /**
     * Only reviewers can submit review actions
     */
    public function authorize(): bool
    {
        return $this->user()->isReviewer();
    }

    /**
     * Validate ONLY the input (no workflow logic here)
     */
    public function rules(): array
    {
        return [
            'action' => 'required|in:approve,reject,return',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Ensure comment is required for destructive actions
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (
                in_array($this->input('action'), ['reject', 'return']) &&
                empty($this->input('comment'))
            ) {
                $validator->errors()->add(
                    'comment',
                    'Comment is required for this action.'
                );
            }
        });
    }
}