<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'serviceCities'=>'array|nullable',
            'serviceCities.*'=>'array:name,province_id',
            'serviceCities.*.name'=>'string|max:255',
            'serviceCities.*.province_id'=>'integer|exists:App\Models\Province,id',
            'online'=>'array:0|nullable',
            'online.0'=>'boolean',
            'stationary'=>'array:0|nullable',
            'stationary.0'=>'boolean'
            
        ];
    }
}
