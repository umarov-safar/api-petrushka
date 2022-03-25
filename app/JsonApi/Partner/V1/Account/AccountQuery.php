<?php

namespace App\JsonApi\Partner\V1\Account;

use App\JsonApi\Admin\V1\Account\AccountQuery as AccountAdminQuery;
use LaravelJsonApi\Laravel\Http\Requests\ResourceQuery;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

//class AccountQuery extends ResourceQuery
class AccountQuery extends AccountAdminQuery
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
                JsonApiRule::filter()->forget('id'),
            ],
            'include' => [
                'nullable',
                'string',
                JsonApiRule::includePaths(),
            ],
            'page' => JsonApiRule::notSupported(),
            'sort' => JsonApiRule::notSupported(),
            'withCount' => [
                'nullable',
                'string',
                JsonApiRule::countable(),
            ],
        ];
    }
    */
}
