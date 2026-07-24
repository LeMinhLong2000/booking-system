<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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

            'room_id' => [
                'required',
                'exists:rooms,id'
            ],

            'guest_name' => [
                'required',
                'string',
                'max:255'
            ],

            'guest_phone' => [
                'required',
                'string',
                'max:20'
            ],

            'guest_email' => [
                'nullable',
                'email'
            ],

            'check_in' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'check_out' => [
                'required',
                'date',
                'after:check_in'
            ],

            'total_price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'pending',
                    'confirmed',
                    'checked_in',
                    'checked_out',
                    'cancelled'
                ])
            ],

            'notes' => [
                'nullable',
                'string'
            ]
        ];
    }
}
