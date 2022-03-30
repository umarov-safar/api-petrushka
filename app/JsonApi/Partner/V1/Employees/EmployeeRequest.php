<?php

namespace App\JsonApi\Partner\V1\Employees;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use App\JsonApi\Admin\V1\PartnerUsers\PartnerUserRequest;
use Auth;


class EmployeeRequest extends PartnerUserRequest
{

    protected function prepareForValidation()
    {

        parent::prepareForValidation();
    }


    /**
     * Get the validation rules for the resource.
     * Не сработало через наследование, т.к. нужно передать базовую модель '$partner_user = $this->model()->toBase();'
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        // проверка на то, что partnerId связан с текущим пользователем и в ней он является админом (или есть разрешение)
        //unset($rules['partnerId']);
        $rules['partnerId'] = ['required', 'integer'];

        $user = Auth::user();
        $partners = $user->partners()->forAdminUser($user->id)->get();
        if($partners) {
            $partnersIds = $partners->pluck('id')->all() ?? [];
            if(count($partnersIds) > 0){
                $rules['partnerId'] = ['required', 'integer', 'in:'.implode(',',$partnersIds)];
            }
        }
        // dd($partners);
        // exit;
        if($this->isMethod('PATCH')){
            unset($rules['partnerId']); // убрать проверку на companyId, т.к. компанию после назначения уже поменять нельзя
        }
        return $rules;

        /*
        $partner_user = $this->model()->toBase();

        $unique = Rule::unique('partner_user');

        if($partner_user) {
            $unique = $unique->ignore($partner_user);
        }

        $rules =  [
            //'partnerId' => 'required|exists:partners,id',
            'phone' => 'required|digits_between:3,15|' . $unique,
            'status' => 'boolean'
        ];
        if($this->isMethod('PATCH')){
            unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
            //unset($rules['partnerId']); // убрать проверку на companyId, т.к. компанию после назначения уже поменять нельзя
        }
        return $rules;
        */
    }

}
