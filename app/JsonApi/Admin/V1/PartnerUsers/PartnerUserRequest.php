<?php

namespace App\JsonApi\Admin\V1\PartnerUsers;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class PartnerUserRequest extends ResourceRequest
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
        $partner_user = $this->model();
        //\Log::debug($partner_user);
        //\Log::info(print_r($partner_user, true));

        $unique = Rule::unique('partner_user');
        \Log::debug($unique);
        \Log::debug("\n");

        if($partner_user) {
            $unique = $unique->ignore($partner_user);
            \Log::debug($unique);
            \Log::debug("\n");
        }

        $rules =  [
            'partnerId' => 'required|exists:partners,id',
            'phone' => 'required|digits_between:3,15|' . $unique,
            'status' => 'boolean'
        ];
        if($this->isMethod('PATCH')){
            unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
            unset($rules['partnerId']); // убрать проверку на companyId, т.к. компанию после назначения уже поменять нельзя
        }
        return $rules;
    }

}
