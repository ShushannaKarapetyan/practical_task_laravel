<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\MaxActivitiesPerDate;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:100',
            'image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,gif',
            'date' => [
                'required',
                'date',
                'after_or_equal:now',
                new MaxActivitiesPerDate,
            ],
        ];
    }
}
