<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\JsonApi\Proxies\AttributePartner;
use App\Models\Attribute;
use App\Dtos\AttributeDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Attributes\AttributeQuery;
use App\JsonApi\Partner\V1\Attributes\AttributeRequest;
use App\JsonApi\Partner\V1\Attributes\AttributeSchema;
use App\Services\AttributeService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class AttributeController extends Controller
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
            $attributes['attributeType'],
            $attributes['slug'],
            $attributes['position'] ?? Attribute::DEFAULT_POSITION,
            $attributes['partnerId'] ?? NULL,
            $attributes['isGlobal'] ?? Attribute::IS_GLOBAL_NO
        );

        $attribute = $this->attributeService->create($dto);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = Attribute::find($attribute->getKey());

        $attributePartner = new AttributePartner($attribute);

        return DataResponse::make($attributePartner);

    }

    public function update(
        AttributeSchema $schema,
        AttributeRequest $request,
        AttributeQuery $query,
        AttributePartner $attributePartner
    )
    {
        $attributes = $request->data['attributes'];

        $dto = new AttributeDto(
            $attributes['name'],
            $attributes['attributeType'],
            $attributes['slug'],
            $attributes['position'] ?? $attributePartner->position,
            $attributes['partnerId'] ?? $attributePartner->partner_id,
            $attributes['isGlobal'] ?? $attributePartner->is_global
        );


        $attribute = $this->attributeService->update($dto, $attributePartner->id);

        if(!$attribute) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $attribute = Attribute::find($attribute->getKey());
        $attributePartner = new AttributePartner($attribute);

        return DataResponse::make($attributePartner);
    }

}
