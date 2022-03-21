<?php

namespace App\JsonApi\Admin\V1\Users;

use App\JsonApi\Filters\Like;
use App\Models\User;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOneThrough;

class UserSchema extends Schema
{
    /**
     * Default pagination
     * @var array|string[]|null
     */
    protected ?array $defaultPagination = ['limit' => 25];
    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = User::class;

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
            Str::make('email'),
            Str::make('phone')->readOnly(), // запрещено менять номер телефона!
            Number::make('code')->hidden()->readOnly(),
            Boolean::make('isBlock'),
            //BelongsToMany::make('roles'),
            HasMany::make('roles')->type('roles'),
            /*HasMany::make('roles')->withFilters(
                Where::make('role_name','name')
            ),*/
            HasOneThrough::make('partner')->type('partners'),
            HasOneThrough::make('company')->type('companies'),
            BelongsToMany::make('abilities')->type('abilities'),
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
            WhereIdIn::make($this)->delimiter(','), // filter[id]=x,y
            //Has::make($this, 'roles'),
            WhereHas::make($this, 'roles'), // filter[roles][name]=value
            Like::make('name'), // filter[name]=value
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
