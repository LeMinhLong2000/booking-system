<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_type_id' => [
                'required',
                'exists:room_types,id'
            ],

            'room_number' => [
                'required',
                'string',
                'max:20',
                'unique:rooms,room_number'
            ],

            'floor' => [
                'required',
                'integer',
                'min:1'
            ],

            'status' => [
                'required',
                Rule::in([
                    'available',
                    'occupied',
                    'maintenance'
                ])
            ]
        ];
    }
}
