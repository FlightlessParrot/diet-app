<?php

namespace App\Http\Requests;

use App\Enums\Title;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSpecialist extends FormRequest
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
            'number'=>'required|string|max:15',
            'targets'=>'array|nullable',
            'targets.*'=>'numeric|exists:App\Models\Target,id',
        ];
    }
}
