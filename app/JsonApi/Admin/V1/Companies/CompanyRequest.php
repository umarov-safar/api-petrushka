<?php

namespace App\JsonApi\Admin\V1\Companies;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CompanyRequest extends ResourceRequest
{

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
            'adminUserId' => 'required|exists:users,id',
        ];
    }

}
