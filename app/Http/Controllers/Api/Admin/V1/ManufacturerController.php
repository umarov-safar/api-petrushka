<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\ManufacturerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Manufacturers\ManufacturerQuery;
use App\JsonApi\Admin\V1\Manufacturers\ManufacturerRequest;
use App\JsonApi\Admin\V1\Manufacturers\ManufacturerSchema;
use App\Models\Manufacturer;
use App\Services\ManufacturerService;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Contracts\Store\Store as StoreContract;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class ManufacturerController extends Controller
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

    protected ManufacturerService $manufacturerService;


    /**
     * @param ManufacturerService $manufacturerService
     */
    public function __construct(ManufacturerService $manufacturerService)
    {
        $this->manufacturerService = $manufacturerService;
    }


    public function store(ManufacturerSchema $schema, ManufacturerRequest $request, ManufacturerQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new ManufacturerDto($attributes['name']);

        $manufacturer = $this->manufacturerService->create($dto);

        if(!$manufacturer) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $manufacturer = Manufacturer::find($manufacturer->getKey());

        return DataResponse::make($manufacturer);
    }



    public function update(ManufacturerSchema $schema, ManufacturerRequest $request, ManufacturerQuery $query, Manufacturer $manufacturer)
    {
        $attributes = $request->data['attributes'];

        $dto = new ManufacturerDto($attributes['name']);

        $manufacturer = $this->manufacturerService->create($dto, $manufacturer->id);

        if(!$manufacturer) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        return DataResponse::make($manufacturer);
    }

}
