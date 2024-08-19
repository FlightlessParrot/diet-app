<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !==null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "province_id" => "required|numeric|exists:provinces,id",
            "code"=>"required|string|max:6",
            "line_1"=> "nullable|string|max:250",
            "line_2" => "nullable|string|max:250",
            "city"=> "required|string|max:250",
            'park'=>'nullable|boolean'
        ];
    }
}
