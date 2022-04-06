<?php

namespace App\JsonApi\Proxies;

use LaravelJsonApi\Eloquent\Proxy;
use App\Models\Category;

class CategoryCustomer extends Proxy
{
    public function __construct(Category $category = null)
    {
        parent::__construct($category ?: new Category());
    }
}
