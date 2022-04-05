<?php

namespace App\JsonApi\Admin\V1\AttributeValues;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class AttributeValueRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'attributeId' => 'required|integer|exists:attributes,id',
            'isGlobal' => 'nullable|boolean',
            'value' => 'required',
            'position' => 'nullable|integer',
            'partnerId' => 'nullable|integer|exists:partners,id'
        ];
    }

}
