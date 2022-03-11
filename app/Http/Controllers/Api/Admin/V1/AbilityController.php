<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\AbilityDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Abilities\AbilityQuery;
use App\JsonApi\Admin\V1\Abilities\AbilityRequest;
use App\JsonApi\Admin\V1\Abilities\AbilitySchema;
use App\Services\AbilityService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use Silber\Bouncer\Database\Ability;

class AbilityController extends Controller
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


    /**
     * @var AbilityService
     */
    protected AbilityService $abilityService;


    public function __construct()
    {
        $this->abilityService = new AbilityService();
    }

    /**
     * Create ability for roles and models
     * @param AbilitySchema $schema
     * @param AbilityRequest $request
     * @param AbilityQuery $query
     * @return false|DataResponse
     */
    public function storeStop(AbilitySchema $schema, AbilityRequest $request, AbilityQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new AbilityDto(
            $attributes['name'],
            $attributes['title'] ?? null
        );

        $ability = $this->abilityService->create($dto);

        if(!$ability)
        {
            return false;
        }

        $ability = Ability::find($ability->getKey());
        return new DataResponse($ability);
    }


    /**
     * Update ability
     * @param AbilitySchema $schema
     * @param AbilityRequest $request
     * @param AbilityQuery $query
     * @param Ability $ability
     * @return false|DataResponse
     */
    public function updateStop(AbilitySchema $schema, AbilityRequest $request, AbilityQuery $query, Ability $ability)
    {
        $attributes = $request->data['attributes'];

        $dto = new AbilityDto(
            $attributes['name'],
            $attributes['title'] ?? $ability->title
        );

        $ability = $this->abilityService->update($dto, $ability->id);

        if(!$ability) {
            return false;
        }

        $ability = Ability::find($ability->getKey());
        return new DataResponse($ability);
    }

}
