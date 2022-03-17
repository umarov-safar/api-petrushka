<?php

namespace App\JsonApi\Admin\V1\CompanyUsers;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class CompanyUserRequest extends ResourceRequest
{

    protected function prepareForValidation()
    {

        if($this->isMethod("DELETE")) return;
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
        $company_user = $this->model();

        $unique = Rule::unique('company_user');

        if($company_user) {
            $unique = $unique->ignore($company_user);
        }

        $rules = [
            'companyId' => 'required|exists:companies,id',
            'phone' => 'required|digits_between:3,15|' . $unique,
            'status' => 'boolean'
        ];

        if($this->isMethod('PATCH')){
            unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
            unset($rules['companyId']); // убрать проверку на companyId, т.к. компанию после назначения уже поменять нельзя
        }
        return $rules;
    }

}
