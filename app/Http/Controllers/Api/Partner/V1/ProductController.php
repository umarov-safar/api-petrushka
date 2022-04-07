<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\ProductDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Products\ProductQuery;
use App\JsonApi\Partner\V1\Products\ProductRequest;
use App\JsonApi\Partner\V1\Products\ProductSchema;
use App\JsonApi\Proxies\ProductPartner;
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

        return new DataResponse(new ProductPartner($product));

    }



    public function update(ProductSchema $schema, ProductRequest $request, ProductQuery $query, ProductPartner $productPartner)
    {
        $attributes = $request->data['attributes'];

        $dto = new ProductDto(
            $attributes['name'],
            $attributes['sku'],
            $attributes['description'],
            $attributes['descriptionOriginal'],
            $attributes['slug'],
            $attributes['categoryId'],
            $attributes['isAlcohol'] ?? $productPartner->is_alcohol,
            $attributes['humanVolume'] ?? $productPartner->human_volume,
            $attributes['canonicalPermalink'] ?? $productPartner->canonical_permalink,
            $attributes['brandId'] ?? $productPartner->brand_id,
            $attributes['manufacturerId'] ?? $productPartner->manufacturer_id,
            $attributes['manufacturingCountryId'] ?? $productPartner->manufacturing_country_id,
            $attributes['partnerId'] ?? $productPartner->partner_id,
            $attributes['attributes'] ?? $productPartner->attributes

        );

        $product = $this->productService->update($dto, $productPartner->id);

        if(!$product) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $product = Product::find($product->getKey());

        return new DataResponse(new ProductPartner($product));
    }
}
