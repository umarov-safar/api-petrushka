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
        $company = $this->model();

        $unique = Rule::unique('companies');

        if($company) {
            $unique = $unique->ignore($company);
        }

        return [
            'inn' => 'required|digits_between:10,12|' . $unique,
            'info' => 'nullable',
            'isBlock' => 'boolean',
            'phone' => 'required|digits_between:3,15|'. $unique,
        ];
    }

}
