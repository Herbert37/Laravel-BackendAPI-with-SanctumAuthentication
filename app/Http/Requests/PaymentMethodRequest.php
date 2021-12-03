<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'card_brand' => ['nullable', 'string'],
            'card_number' => ['required', 'numeric','min:14'],
            'exp_month' => ['required', 'date_format:m'],
            'exp_year' => ['required', 'date_format:y'],
            'cvv' => ['required', 'numeric','min:3']
        ];
    }
}
