<?php

namespace App\JsonApi\Admin\V1\Brands;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BrandRequest extends ResourceRequest
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

//        $manufacturing_country = $this->model();
//        $unique = Rule::unique('manufacturing_countries');
//
//        if($manufacturing_country) $unique = $unique->ignore($manufacturing_country);

        return [
            'name' => 'required|string',
            'slug' => 'required|string',
//            'slug' => 'required|string|' . $unique,
        ];
    }

}
