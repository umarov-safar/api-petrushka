<?php

namespace App\JsonApi\Admin\V1\Companies;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CompanyRequest extends ResourceRequest
{

    protected function prepareForValidation()
    {
        if($this->isMethod('DELETE')) return;
        if($this->isMethod('PATCH')) return;

        $data = $this->data;
        $data['attributes']['phone'] = preg_replace('/[^0-9]/', '', @$this->data['attributes']['phone']);

        $this->getInputSource()->replace(['data' => $data]);
    }

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        //$company = $this->model();

        /*$unique = Rule::unique('companies');

        if($company) {
            $unique = $unique->ignore($company);
        }*/

        $rules = [
            //'inn' => 'required|digits_between:10,12|' . $unique,
            'inn' => 'required|digits_between:10,12',
            'info' => 'nullable',
            'isBlock' => 'boolean',
            //'phone' => 'required|digits_between:3,15|'. $unique,
            'phone' => 'required|digits_between:3,15',
        ];
        if($this->isMethod('PATCH')) unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
        return $rules;
    }

}
