<?php

namespace App\JsonApi\Admin\V1\Attributes;

use App\Models\Attribute;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class AttributeRequest extends ResourceRequest
{

    protected function prepareForValidation()
    {
        $data = $this->data;
        $data['attributes']['slug'] = Str::slug($data['attributes']['slug'] ?? $data['attributes']['name']);

        $this->getInputSource()->replace(['data' => $data]);
    }

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        $attribute = $this->model();
        $unique = Rule::unique('attributes');

        if($attribute) $unique = $unique->ignore($attribute);

        $types = array_keys(Attribute::TYPES_OF_ATTRIBUTES);

        return [
            'name' => 'required|string|min:2',
            'slug' => 'required|string|' . $unique,
            'attribute_type' => 'required|string|' . Rule::in($types),
            'position' => 'nullable|int',
            'partnerId' => 'nullable|int|exists:partners,id'
        ];
    }

}
