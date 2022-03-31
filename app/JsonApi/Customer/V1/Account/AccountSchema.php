<?php

namespace App\JsonApi\Customer\V1\Account;

use App\JsonApi\Filters\Like;
use App\Models\User;
use App\JsonApi\Proxies\Account; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
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
//use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOneThrough;
use LaravelJsonApi\Eloquent\ProxySchema;

class AccountSchema extends ProxySchema
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
    public static string $model = Account::class;

    /**
     * Get the JSON:API resource type.
     *
     * @return string
     */
    public static function type(): string
    {
        return 'account';
    }

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
            //Number::make('code')->hidden()->readOnly(),
            Boolean::make('isBlock')->readOnly(),
            //BelongsToMany::make('roles'),
            //HasMany::make('partners')->type('partners')->readOnly(),
            //HasMany::make('companies')->type('my-companies')->readOnly(),
            HasMany::make('myCompanies','companies')->type('my-companies')->readOnly(),
            //HasOneThrough::make('partner')->type('partners'),
            //HasOneThrough::make('company')->type('companies'),
            HasMany::make('roles')->type('roles')->readOnly(),
            /*HasMany::make('roles')->withFilters(
                Where::make('role_name','name')
            ),*/
            BelongsToMany::make('abilities')->type('abilities')->readOnly(),
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
        return [];
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
