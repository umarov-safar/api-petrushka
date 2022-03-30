<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\AttributeValueDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\AttributeValues\AttributeValueQuery;
use App\JsonApi\Admin\V1\AttributeValues\AttributeValueRequest;
use App\JsonApi\Admin\V1\AttributeValues\AttributeValueSchema;
use App\Models\AttributeValue;
use App\Services\AttributeValueService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class AttributeValueController extends Controller
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

    protected AttributeValueService $attributeValueService;

    /**
     * @param AttributeValueService $attributeValueService
     */
    public function __construct(AttributeValueService $attributeValueService)
    {
        $this->attributeValueService = $attributeValueService;
    }


    public function store(AttributeValueSchema $schema, AttributeValueRequest $request, AttributeValueQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new AttributeValueDto(
            $attributes['value'],
            $attributes['attributeId'],
            $attributes['position'] ?? NULL,
            $attributes['partnerId'] ?? NULL,
            $attributes['isGlobal'] ?? 0
        );

        $attribute = $this->attributeValueService->create($dto);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = AttributeValue::find($attribute->getKey());

        return DataResponse::make($attribute);

    }


    public function update(AttributeValueSchema $schema, AttributeValueRequest $request, AttributeValueQuery $query, AttributeValue $attributeValue)
    {
        $attributes = $request->data['attributes'];

        $dto = new AttributeValueDto(
            $attributes['value'],
            $attributes['attributeId'],
            $attributes['position'] ?? $attributeValue->position,
            $attributes['partnerId'] ?? $attributeValue->partner_id,
            $attribute['isGlobal'] ?? $attributeValue->is_global
        );

        $attribute = $this->attributeValueService->update($dto, $attributeValue->id);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = AttributeValue::find($attribute->getKey());

        return DataResponse::make($attribute);

    }
}
