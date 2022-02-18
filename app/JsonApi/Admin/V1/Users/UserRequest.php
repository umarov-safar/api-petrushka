<?php

namespace App\JsonApi\Admin\V1\Users;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserRequest extends ResourceRequest
{

    public function prepareForValidation()
    {
        if($this->isMethod('DELETE')) return;

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
        $user = $this->model();

        $unique = Rule::unique('users');

        if($user) {
            $unique = $unique->ignore($user);
        }

        return [
            // @TODO
            'name' => 'nullable|string',
            'email' => 'nullable|email|' . $unique,
            'isBlock' => 'boolean',
            'phone' => 'required|digits_between:3,15|'. $unique,
        ];
    }

}
