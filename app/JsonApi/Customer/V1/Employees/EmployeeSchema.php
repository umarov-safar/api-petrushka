<?php

namespace App\JsonApi\Customer\V1\Employees;

use App\JsonApi\Proxies\CompanyUserCustomer as CompanyUser; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\ProxySchema;

class EmployeeSchema extends ProxySchema
{
    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = CompanyUser::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('companyId'),
            Number::make('userId'),
            Str::make('phone'),
            Boolean::make('status'),
            Boolean::make('isAdmin')->readOnly(),
            Str::make('settingInfo'),
            BelongsTo::make('myCompany','companies')->type('my-companies')->readOnly(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make()
            ->withPageKey('page')
            ->withPerPageKey('limit');
    }

}
