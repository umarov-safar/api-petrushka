<?php

namespace App\JsonApi\Admin\V1\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CategoryRequest extends ResourceRequest
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
        $category = $this->model();

        $rules = [
            'name' => 'required|string|min:2',
            'categoryType' => 'required|integer|' . Rule::in(Category::TYPES),
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'slug' => 'required|string|unique:categories,slug',
            'parentId' => 'nullable|integer|exists:categories,id',
            'iconUrl' => 'nullable|string',
            'altIcon' => 'nullable|string',
            'canonicalUrl' => 'nullable|string',
            'depth' => 'nullable|integer',
            'requirements' => 'nullable|array',
            'relatedPartners' => 'nullable|array',
            'relatedPartners.*.id' => 'nullable|exists:partners,id',
            'relatedPartners.*.categoryName' => 'nullable|string',
            'relatedPartners.*.active' => 'nullable|boolean',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'nullable|exists:attributes,id',
            'attributes.*.position' => 'nullable|integer',
            'attributes.*.presentation' => 'nullable|string',
            'isAlcohol' => 'nullable|boolean'
        ];

        if($category) {
            $rules['slug'] = $rules['slug'] . ',' . $category->id;
        }

        return  $rules;
    }

}
