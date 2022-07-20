<?php

namespace App\JsonApi\Partner\V1\Attributes;

use App\JsonApi\Proxies\AttributePartner as Attribute;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\ProxySchema;

class
AttributeSchema extends ProxySchema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Attribute::class;


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
            Str::make('attributeType', 'type'), // type is not supported by  JSON:API. The 'attribute_type' is fake for 'type' column.
            Str::make('slug'),
            Number::make('position'),
            Boolean::make('isGlobal'),
            Number::make('partnerId'),
            HasMany::make('values')->type('attribute-values'),
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
