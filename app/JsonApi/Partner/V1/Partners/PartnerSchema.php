<?php

namespace App\JsonApi\Partner\V1\Partners;

use App\JsonApi\Proxies\PartnerPartner as Partner; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
//use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\ProxySchema;

class PartnerSchema extends ProxySchema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Partner::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('name'),
            Str::make('info'),
            Str::make('phone')->readOnly(),
            Number::make('adminUserId')->readOnly(),
            Boolean::make('isBlock')->readOnly(),
            //BelongsTo::make('owner')->type('users'),
            //BelongsToMany::make('partnerUsers'),
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
