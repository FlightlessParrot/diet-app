<?php

namespace App\Http\Requests;

use App\Enums\SocialMedia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocialMediaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url'=>'string|required|max:255',
            'type'=>['required', Rule::enum(SocialMedia::class)]
        ];
    }
}
