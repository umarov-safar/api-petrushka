<?php

namespace App\JsonApi\Partner\V1\Categories;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use App\JsonApi\Admin\V1\Categories\CategoryRequest  as AdminCategoryRequest;

class CategoryRequest extends AdminCategoryRequest
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
        $rules['relatedPartners.*.id'] = 'required|integer|' . Rule::in($partnersIds);

        return $rules;
    }

}
