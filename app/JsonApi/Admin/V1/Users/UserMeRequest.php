<?php

namespace App\JsonApi\Admin\V1\Users;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserMeRequest extends UserRequest
{
    public function prepareForValidation()
    {
        if($this->isMethod('POST')){
            // обработка сработает для create()
            $data = $this->data;
            $data['attributes']['isBlock'] = 0; //  запретить блокировать текущего пользователя самим собой
            unset($data['attributes']['isBlock']);
            $data['attributes']['roles'] = NULL;
            unset($data['attributes']['roles']); //  запретить менять самому себе роль
            $data['attributes']['abilities'] = NULL;
            unset($data['attributes']['abilities']); //  запретить менять самому себе возможности
            $data['attributes']['phone'] = NULL;
            unset($data['attributes']['phone']); //  запретить менять самому себе номер телефона
            $this->getInputSource()->replace(['data' => $data]);
        }
    }
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['phone']); // убрать проверку на номер телефона при редактировании пользователя
        return $rules;
    }
}
