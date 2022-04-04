<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\BrandDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Brands\BrandQuery;
use App\JsonApi\Admin\V1\Brands\BrandRequest;
use App\JsonApi\Admin\V1\Brands\BrandSchema;
use App\Models\Brand;
use App\Services\BrandService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class BrandController extends Controller
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


    protected BrandService $brandService;

    /**
     * @param BrandService $brandService
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }


    /**
     * @param BrandSchema $schema
     * @param BrandRequest $request
     * @param BrandQuery $query
     * @return DataResponse|ErrorResponse
     */
    public function store(BrandSchema $schema, BrandRequest $request, BrandQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new BrandDto(
            $attributes['name'],
            $attributes['slug']
        );

        $brand = $this->brandService->create($dto);

        if(!$brand) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $brand = Brand::find($brand->getKey());

        return DataResponse::make($brand);
    }


    /**
     * @param BrandSchema $schema
     * @param BrandRequest $request
     * @param BrandQuery $query
     * @return DataResponse|ErrorResponse
     */
    public function update(
        BrandSchema $schema,
        BrandRequest $request,
        BrandQuery $query,
        Brand $brand
    )
    {
        $attributes = $request->data['attributes'];

        $dto = new BrandDto(
            $attributes['name'],
            $attributes['slug']
        );

        $brand = $this->brandService->update($dto, $brand->id);

        if(!$brand) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        return DataResponse::make($brand);
    }

}
