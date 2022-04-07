<?php

namespace App\JsonApi\Admin\V1\Products;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ProductRequest extends ResourceRequest
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
        $product = $this->model();

        $rules = [
            'name' => 'required|string',
            'sku' => 'required|integer',
            'description' => 'required|string',
            'descriptionOriginal' => 'required|string',
            'slug' => 'required|string|unique:products,slug',
            'humanVolume' => 'nullable|string',
            'canonicalPermalink' => 'nullable|string',
            'isAlcohol' => 'nullable|boolean',
            'brandId' => 'nullable|integer|exists:brands,id',
            'categoryId' => 'nullable|integer|exists:categories,id',
            'manufacturerId' => 'nullable|integer|exists:manufacturers,id',
            'manufacturingCountryId' => 'nullable|integer|exists:manufacturing_countries,id',
            'partnerId' => 'nullable|integer|exists:partners,id',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'nullable|exists:attributes,id',
            'attributes.*.position' => 'nullable|integer',
            'attributes.*.presentation' => 'nullable|string',
            'attributes.*.value_id' => 'nullable|exists:attribute_values,id',
        ];

        if($product) {
            $rules['slug'] = $rules['slug'] . ',' . $product->id;
        }

        return $rules;
    }

}
