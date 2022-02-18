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

        $unique = Rule::unique('partner_user');

        if($partner_user) {
            $unique = $unique->ignore($partner_user);
        }

        return [
            'partnerId' => 'required|exists:partners,id',
            'phone' => 'required|digits_between:3,15|' . $unique,
            "status" => 'boolean'
        ];
    }

}
