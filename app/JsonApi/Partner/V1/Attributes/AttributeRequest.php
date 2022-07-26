<?php

namespace App\JsonApi\Partner\V1\Attributes;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use \App\JsonApi\Admin\V1\Attributes\AttributeRequest as AdminAttributeRequest;

class AttributeRequest extends AdminAttributeRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $user = auth()->user();

        $partners = $user->partners()->forAdminUser($user->id)->get();
        $partnersIds = $partners->pluck('id')->all() ?? [];

        //if the $partnersIds is equal to empty array then never let  user to create attribute because he is not an admin
        $rules['partnerId'] = 'required|integer|' . Rule::in($partnersIds);

        return $rules;
    }

}
