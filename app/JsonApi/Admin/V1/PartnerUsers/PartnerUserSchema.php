<?php

namespace App\JsonApi\Admin\V1\PartnerUsers;

use App\Models\PartnerUser;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class PartnerUserSchema extends Schema
{

    public static function type(): string
    {
        return "partner-users";
    }

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = PartnerUser::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('userId')->readOnly(),
            Number::make('partnerId'),
            Str::make('phone'),
            Str::make('settingInfo'),
            Boolean::make('status'),
            Boolean::make('isAdmin')->readOnly(),
            BelongsTo::make('partner','partner')->type('partners')->readOnly(),
            BelongsTo::make('user')->type('users')->readOnly(),
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
