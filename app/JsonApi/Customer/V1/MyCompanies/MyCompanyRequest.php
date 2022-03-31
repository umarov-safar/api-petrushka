<?php

namespace App\JsonApi\Customer\V1\MyCompanies;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class MyCompanyRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        /*$company = $this->model();

        $unique = Rule::unique('companies');

        if($company) {
            $unique = $unique->ignore($company);
        }*/

        return [
            'inn' => 'required|digits_between:10,12',
            'info' => 'nullable',
            //'isBlock' => 'boolean',
            //'phone' => 'required|digits_between:3,15|'. $unique,
        ];
    }

}
