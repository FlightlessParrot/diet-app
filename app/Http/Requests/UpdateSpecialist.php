<?php

namespace App\Http\Requests;

use App\Enums\Specialization;
use App\Enums\Title;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialist extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:250',
            'surname'=>'required|string|max:250',
            'title'=>[Rule::enum(Title::class),'nullable'],
            'specializations'=>'array|nullable',
            'specializations.*'=>[Rule::enum(Specialization::class),'nullable'],
            'targets'=>'array|nullable',
            'targets.*'=>'numeric|exists:App\Models\Target,id',
        ];
    }
}
