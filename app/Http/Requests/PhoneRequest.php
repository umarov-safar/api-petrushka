<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
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
     * Make phone valide before checking for example:
     * +7 (999) 495 45 45 -> 79994954545
     * +7-999-495-45-45 -> 79994954545
     */

    public function prepareForValidation()
    {
        $this->merge([
            'phone' => preg_replace('/[^0-9]/', '', $this->phone)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'phone' => 'required|digits_between:3,12',
        ];
    }


    /**
     * Notify user if phone is invalid format
     */

    public function messages()
    {
        return [
            'phone.required' => 'Заполните поля телефона',
            'phone.digits_between' => 'Неверный телефон',
        ];
    }
}
