<?php

namespace App\JsonApi\Customer\V1\Account;

use App\JsonApi\Admin\V1\Account\AccountRequest as AccountAdminRequest;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use Auth;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

//class AccountRequest extends ResourceRequest
class AccountRequest extends AccountAdminRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    /*public function rules(): array
    {
        //$user = $this->model()->toBase();
        $user = Auth::user();

        $unique = Rule::unique('users');

        if($user) {
            $unique = $unique->ignore($user);
        }
        $rules = [
            // @TODO
            'name' => 'nullable|string',
            'email' => 'nullable|email|' . $unique,
        ];
        // роли (roles). роль должна быть  с id 1-4;

        // возможности (abilities) пока без проверок
        return $rules;
    }*/


    /*public function messages()
    {
        return [
            'isBlock.boolean' => 'isBlock должно быть 0 или 1',
            'phone.required' => 'Поле телефон обязательное' // только при создании Пользователя
        ];
    }*/

}
