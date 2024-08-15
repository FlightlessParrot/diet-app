<?php

namespace App\Http\Requests;

use App\Enums\DaysOfWeek;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->specialist!==null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'selectedDate'=>'array:start,end',
            'selectedDate.start'=>'required|date|after_or_equal:tomorrow',
            'selectedDate.end'=>'required|date|after:selectedDate.start',
            'address'=>'nullable|exists:App\Models\Address,id',
            'day'=>['nullable',Rule::enum(DaysOfWeek::class)]
        ];
    }
}
