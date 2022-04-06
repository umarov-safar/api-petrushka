<?php

namespace App\JsonApi\Proxies;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\Proxy;

class ProductCustomer extends Proxy
{
    public function __construct(Product $product = null)
    {
        parent::__construct($product ?: new Product());
    }
}
