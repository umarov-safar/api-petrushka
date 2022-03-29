<?php

namespace App\JsonApi\Customer\V1\Account;

use App\JsonApi\Admin\V1\Account\AccountCollectionQuery as AccountAdminCollectionQuery;
use LaravelJsonApi\Laravel\Http\Requests\ResourceQuery;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class AccountCollectionQuery extends AccountAdminCollectionQuery
{

    /**
     * Get the validation rules that apply to the request query parameters.
     *
     * @return array
     */
    /*
    public function rules(): array
    {
        return [
            'fields' => [
                'nullable',
                'array',
                JsonApiRule::fieldSets(),
            ],
            'filter' => [
                'nullable',
                'array',
                JsonApiRule::filter(),
            ],
            'include' => [
                'nullable',
                'string',
                JsonApiRule::includePaths(),
            ],
            'page' => [
                'nullable',
                'array',
                JsonApiRule::page(),
            ],
            'sort' => [
                'nullable',
                'string',
                JsonApiRule::sort(),
            ],
            'withCount' => [
                'nullable',
                'string',
                JsonApiRule::countable(),
            ],
        ];
    }
    */
}
