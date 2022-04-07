<?php

namespace App\JsonApi\Partner\V1\Products;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;
use App\JsonApi\Admin\V1\Products\ProductRequest as AdminProductRequest;

class ProductRequest extends AdminProductRequest
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
        $rules['partnerId'] = 'required|integer|' . Rule::in($partnersIds);

        return $rules;
    }

}
