<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\ManufacturingCountryDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\ManufacturingCountries\ManufacturingCountryQuery;
use App\JsonApi\Admin\V1\ManufacturingCountries\ManufacturingCountryRequest;
use App\JsonApi\Admin\V1\ManufacturingCountries\ManufacturingCountrySchema;
use App\Models\ManufacturingCountry;
use App\Services\ManufacturingCountryService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class ManufacturingCountryController extends Controller
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

    protected ManufacturingCountryService $manufacturingCountryService;


    /**
     * @param ManufacturingCountryService $manufacturingCountryService
     */
    public function __construct(ManufacturingCountryService $manufacturingCountryService)
    {
        $this->manufacturingCountryService = $manufacturingCountryService;
    }


    /**
     * @param ManufacturingCountrySchema $schema
     * @param ManufacturingCountryRequest $request
     * @param ManufacturingCountryQuery $query
     * @return DataResponse|ErrorResponse
     */
    public function store(
        ManufacturingCountrySchema $schema,
        ManufacturingCountryRequest $request,
        ManufacturingCountryQuery $query
    )
    {
        $attributes = $request->data['attributes'];

        $dto = new ManufacturingCountryDto(
            $attributes['name'],
            $attributes['slug']
        );

        $manufacturing_country = $this->manufacturingCountryService->create($dto);

        if(!$manufacturing_country) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $manufacturing_country = ManufacturingCountry::find($manufacturing_country->getKey());

        return DataResponse::make($manufacturing_country);
    }


    /**
     * @param ManufacturingCountrySchema $schema
     * @param ManufacturingCountryRequest $request
     * @param ManufacturingCountryQuery $query
     * @param ManufacturingCountry $manufacturingCountry
     * @return DataResponse|ErrorResponse
     */
    public function update(
        ManufacturingCountrySchema $schema,
        ManufacturingCountryRequest $request,
        ManufacturingCountryQuery $query,
        ManufacturingCountry $manufacturingCountry
    )
    {
        $attributes = $request->data['attributes'];

        $dto = new ManufacturingCountryDto(
            $attributes['name'],
            $attributes['slug']
        );

        $manufacturing_country = $this->manufacturingCountryService->update($dto, $manufacturingCountry->id);

        if(!$manufacturing_country) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        return DataResponse::make($manufacturing_country);
    }

}
