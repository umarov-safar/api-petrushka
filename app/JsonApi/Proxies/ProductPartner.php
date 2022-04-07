<?php

namespace App\JsonApi\Proxies;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\Proxy;
use App\Models\Product;

class ProductPartner extends Proxy
{
    public function __construct(Product $product = null)
    {
        $product = $product ?? new Product();
        self::bootModel($product);

        parent::__construct($product ?: new Product());
    }


    protected static function bootModel(Product $product)
    {
        $user = auth()->user();

        if($user->isA('partner')) {
            $partners = $user->partners()->forAdminUser($user->id)->get();
            if($partners) {

                $partnersIds = $partners->pluck('id')->all() ?? [];

                $product::addGlobalScope('partner_id', function (Builder $builder) use ($partnersIds) {
                    $builder->whereIn('partner_id', $partnersIds);
                });
            }
        }
    }
}
