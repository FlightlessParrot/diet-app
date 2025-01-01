<?php

namespace App\Http\Requests;

use App\Enums\SpecialistPaymentMethods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpecialistPaymentMethodsRequest extends FormRequest
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
            'paymentMethods'=>'array|required',
            'paymentMethods.*'=>[Rule::enum(SpecialistPaymentMethods::class)]
        ];
    }
}
