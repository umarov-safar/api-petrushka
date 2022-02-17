<?php

namespace App\Http\Controllers\Api\Partner;

use App\Dtos\Partner\PartnerUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\PartnerUsers\PartnerUserQuery;
use App\JsonApi\Partner\V1\PartnerUsers\PartnerUserRequest;
use App\JsonApi\Partner\V1\PartnerUsers\PartnerUserSchema;
use App\Models\Partner\PartnerUser;
use App\Models\User;
use App\Services\Partner\PartnerUserService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class PartnerUserController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * Defining company user property
     * @var PartnerUserService
     */
    protected PartnerUserService $partnerUserService;


    public function __construct()
    {
        $this->partnerUserService = new PartnerUserService();
    }


    public function store(PartnerUserSchema $schema, PartnerUserRequest $request, PartnerUserQuery $query)
    {
        $attributes = $request->data['attributes'];

        $user = User::firstOrCreate(['phone' => $attributes['phone']]);

        $dto = new PartnerUserDto(
            $user->id,
            $attributes['partnerId'],
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? 0
        );

        $company_user = $this->partnerUserService->create($dto);

        if(!$company_user) return false;

        $company_user = PartnerUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }


    public function update(PartnerUserSchema $schema, PartnerUserRequest $request, PartnerUserQuery $query, PartnerUser $partnerUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerUserDto(
            $partnerUser->id,
            $attributes['partnerId'],
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? 0
        );

        $company_user = $this->partnerUserService->update($dto, $partnerUser->id);

        if(!$company_user) return false;

        $company_user = PartnerUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }

}
