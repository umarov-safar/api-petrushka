<?php

namespace App\JsonApi\Proxies;


use Illuminate\Database\Eloquent\Builder;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\Proxy;

class AttributePartner extends Proxy
{
    public function __construct(Attribute $attribute = null)
    {
        $attribute = ($attribute ? $attribute : new Attribute());
        self::bootModel($attribute);

        parent::__construct($attribute ?: new Attribute());
    }


    // Получить список только глобальных атрибутов или только своих
    protected static function bootModel(Attribute $attribute)
    {
        $user = auth()->user();

        if($user->isA('partner')) {
            $partners = $user->partners()->forAdminUser($user->id)->get();
            if($partners) {
                $partnersIds = $partners->pluck('id')->all() ?? [];

                $attribute::addGlobalScope('is_global', function (Builder $builder) use ($partnersIds) {
                    $builder->where('is_global', Attribute::IS_GLOBAL_YES)
                        ->orWhereIn('partner_id', $partnersIds);
                });
            }
        }
    }

}
