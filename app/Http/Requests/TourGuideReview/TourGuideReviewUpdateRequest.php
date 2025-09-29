<?php

namespace App\Http\Requests\TourGuideReview;

use Illuminate\Foundation\Http\FormRequest;

class TourGuideReviewUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'review' => ['nullable', 'string', 'max:255'],
            'tour_guide_id' => ['nullable', 'string', 'max:50', 'exists:tour_guides,id'],
        ];
    }
}