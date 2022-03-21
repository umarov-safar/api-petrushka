<?php

namespace App\JsonApi\Admin\V1\Partners;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class PartnerRequest extends ResourceRequest
{

    public function prepareForValidation()
    {
        if($this->isMethod('DELETE')) return;
        if($this->isMethod('PATCH')) return;

        $data = $this->data;
        $data['attributes']['phone'] = preg_replace('/[^0-9]/', '', $this->data['attributes']['phone']);

        $this->getInputSource()->replace(['data' => $data]);
    }



    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $partner = $this->model();

        $unique = Rule::unique('partners');

        if($partner) {
            $unique = $unique->ignore($partner);
        }

        $rules = [
            // @TODO
            'name' => 'required|string',
            'phone' => 'required|digits_between:3,15|'. $unique,
            'isBlock' => JsonApiRule::boolean(),
        ];
        if($this->isMethod('PATCH')) unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
        return $rules;
    }

}
