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

        if($partners) {
            $partnersIds = $partners->pluck('id')->all() ?? [];
            $rules['partnerId'] = 'required|integer|' . Rule::in($partnersIds);
        } else {
            $rules['partnerId'] = 'required|integer|exists:partners,id';
        }

        return $rules;
    }

}
