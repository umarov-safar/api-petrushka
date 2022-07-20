<?php

namespace App\JsonApi\Partner\V1\Categories;

use App\JsonApi\Proxies\CategoryPartner as Category;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\ProxySchema;

class CategorySchema extends ProxySchema
{

    /**
     * The model the schema corresponds to.
     *
     *
     * @var string
     */
    public static string $model = Category::class;

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
            Str::make('slug'),
            Str::make('categoryType', 'type'),
            Number::make('position'),
            Boolean::make('active'),
            Number::make('parentId'),
            Str::make('iconUrl'),
            Str::make('altIcon'),
            Str::make('canonicalUrl'),
            Number::make('depth'),
            Str::make('children'),
            Str::make('requirements'),
            Str::make('attributes'),
            ArrayList::make('relatedPartners'),
            Boolean::make('isAlcohol'),
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
