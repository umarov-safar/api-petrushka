<?php

namespace App\JsonApi\Proxies;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use LaravelJsonApi\Eloquent\Proxy;

class CategoryPartner extends  Proxy
{
    public function __construct(Category $category = null)
    {
        parent::__construct($category ?: new Category());
    }
}
