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

        $unique = Rule::unique('categories');

        if($category) {
            $unique = $unique->ignore($category);
        }

        return [
            'name' => 'required|string|min:2',
            'categoryType' => 'required|integer|' . Rule::in(Category::TYPES),
            'slug' => 'required|string|' . $unique,
            'position' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'parentId' => 'nullable|integer|exists:categories,id',
            'partnerId' => 'nullable|integer|exists:partners,id',
            'iconUrl' => 'nullable|string',
            'altIcon' => 'nullable|string',
            'canonicalUrl' => 'nullable|string',
            'depth' => 'nullable|integer',
            'requirements' => 'nullable|array',
            'attributes' => 'nullable|array',
            'isAlcohol' => 'nullable|boolean'
        ];
    }

}
