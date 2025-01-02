<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'text'=>'max:600|string|required',
            'grade'=>'integer|max:5|min:1',
            'grade_atmosphere'=>'integer|max:5|min:1',
            'grade_punctuality'=>'integer|max:5|min:1',
            'grade_explanation'=>'integer|max:5|min:1'
        ];
    }
}
