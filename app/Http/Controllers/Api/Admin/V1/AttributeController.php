<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\AttributeDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Attributes\AttributeQuery;
use App\JsonApi\Admin\V1\Attributes\AttributeRequest;
use App\JsonApi\Admin\V1\Attributes\AttributeSchema;
use App\Models\Attribute;
use App\Services\AttributeService;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Contracts\Store\Store as StoreContract;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class AttributeController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;


    protected AttributeService $attributeService;

    /**
     * @param AttributeService $attributeService
     */
    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }


    /**
     * @param AttributeSchema $schema
     * @param AttributeRequest $request
     * @param AttributeQuery $query
     */
    public function store(AttributeSchema $schema, AttributeRequest $request, AttributeQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new AttributeDto(
            $attributes['name'],
            $attributes['attribute_type'],
            $attributes['slug'],
            $attributes['position'] ?? 0,
            $attributes['partnerId'] ?? NULL,
            $attributes['isGlobal'] ?? 0
        );

        $attribute = $this->attributeService->create($dto);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = Attribute::find($attribute->getKey());

        return DataResponse::make($attribute);

    }

    public function update(
        AttributeSchema $schema,
        AttributeRequest $request,
        AttributeQuery $query,
        Attribute $attribute
    )
    {
        $attributes = $request->data['attributes'];

        $dto = new AttributeDto(
            $attributes['name'],
            $attributes['attributeType'],
            $attributes['slug'],
            $attributes['position'] ?? $attribute->position,
            $attributes['partnerId'] ?? $attribute->partner_id,
            $attributes['isGlobal'] ?? $attribute->is_global
        );


        $attribute = $this->attributeService->update($dto, $attribute->id);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = Attribute::find($attribute->getKey());

        return DataResponse::make($attribute);
    }

}
