<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//class CodeRequest extends PhoneRequest
class CodeRequest extends FormRequest
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
        if($this->code){
            $this->getInputSource()->replace(['code' => preg_replace('/[^0-9]/', '', $this->code)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|digits:6',
        ];
    }


    /**
     * Notify user if phone is invalid format
     */

    public function messages()
    {
        return [
            'code.required' => 'Заполните поля кода',
            'code.digits' => 'Неверный код',
        ];
    }
}
