<?php

namespace App\JsonApi\Admin\V1\Roles;

use App\Models\Role;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\Scope;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class RoleSchema extends Schema
{

    public static function type(): string
    {
        return 'roles';
    }

    public function meta() {
        return ['foo' => 'bar'];
    }
    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Role::class;

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
            Str::make('title'),
            Number::make('level'),
            Number::make('scope'),
            HasMany::make('abilities'),
            HasMany::make('users'),
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
            Where::make('name'), // filter[name]=value
            // фильтр на получения ролей, которые можно назначать вручную или нельзя
            Scope::make('allow_manual', 'AllowManuallySet')->asBoolean(), // filter[allow_manual]=true || false
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
            ->withPerPageKey('limit')
            ->withDefaultPerPage(20);
    }

}
