<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\ProductDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Products\ProductQuery;
use App\JsonApi\Admin\V1\Products\ProductRequest;
use App\JsonApi\Admin\V1\Products\ProductSchema;
use App\Models\Product;
use App\Services\ProductService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class ProductController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    protected ProductService $productService;


    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function store(ProductSchema $schema, ProductRequest $request, ProductQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new ProductDto(
            $attributes['name'],
            $attributes['sku'],
            $attributes['description'],
            $attributes['descriptionOriginal'],
            $attributes['slug'],
            $attributes['categoryId'],
            $attributes['isAlcohol'] ?? Product::IS_ALCOHOL_NO,
            $attributes['humanVolume'] ?? NULL,
            $attributes['canonicalPermalink'] ?? NULL,
            $attributes['brandId'] ?? NULL,
            $attributes['manufacturerId'] ?? NULL,
            $attributes['manufacturingCountryId'] ?? NULL,
            $attributes['partnerId'] ?? NULL,
            $attributes['attributes'] ?? NULL

        );

        $product = $this->productService->create($dto);

        if(!$product) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }


        $product = Product::find($product->getKey());

        return new DataResponse($product);
    }

    public function update(ProductSchema $schema, ProductRequest $request, ProductQuery $query, Product $product)
    {
        $attributes = $request->data['attributes'];

        $dto = new ProductDto(
            $attributes['name'],
            $attributes['sku'],
            $attributes['description'],
            $attributes['descriptionOriginal'],
            $attributes['slug'],
            $attributes['categoryId'],
            $attributes['isAlcohol'] ?? $product->is_alcohol,
            $attributes['humanVolume'] ?? $product->human_volume,
            $attributes['canonicalPermalink'] ?? $product->canonical_permalink,
            $attributes['brandId'] ?? $product->brand_id,
            $attributes['manufacturerId'] ?? $product->manufacturer_id,
            $attributes['manufacturingCountryId'] ?? $product->manufacturing_country_id,
            $attributes['partnerId'] ?? $product->partner_id,
            $attributes['attributes'] ?? $product->attributes

        );

        $product = $this->productService->update($dto, $product->id);

        if(!$product) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        return new DataResponse($product);
    }

}
