<?php

namespace App\JsonApi\Customer\V1\Employees;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserRequest;
use Auth;

class EmployeeRequest extends CompanyUserRequest
{

    protected function prepareForValidation()
    {
        parent::prepareForValidation();
    }
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['companyId'] = ['required', 'integer'];

        $user = Auth::user();
        $companies = $user->companies()->forAdminUser($user->id)->get();
        if($companies) {
            $companiesIds = $companies->pluck('id')->all() ?? [];
            if(count($companiesIds) > 0){
                $rules['companyId'] = ['required', 'integer', 'in:'.implode(',',$companiesIds)];
            }
        }
        // dd($partners);
        // exit;
        if($this->isMethod('PATCH')){
            unset($rules['companyId']); // убрать проверку на companyId, т.к. компанию после назначения уже поменять нельзя
        }
        return $rules;
    }

}
