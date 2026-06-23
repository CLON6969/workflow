<?php

namespace App\Http\Requests;

use App\Enums\ApplicationStatus;
use Illuminate\Foundation\Http\FormRequest;

class ReviewActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isReviewer();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'action' => 'required|in:approve,reject,return',
        ];

        // Comment is required only for reject and return
        if (in_array($this->action, ['reject', 'return'])) {
            $rules['comment'] = 'required|string|min:5|max:1000';
        } else {
            $rules['comment'] = 'nullable|string|max:1000';
        }

        return $rules;
    }

    /**
     * Convert action to proper status
     */
    public function getNewStatus(): ApplicationStatus
    {
        return match($this->action) {
            'approve' => ApplicationStatus::APPROVED,
            'reject'  => ApplicationStatus::REJECTED,
            'return'  => ApplicationStatus::RETURNED,
            default   => throw new \InvalidArgumentException('Invalid action'),
        };
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [
            'comment.required' => 'A comment is required when rejecting or returning an application.',
            'comment.min'      => 'Comment must be at least 5 characters.',
        ];
    }
}