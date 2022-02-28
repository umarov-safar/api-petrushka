<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\PartnerUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Employees\EmployeeQuery;
use App\JsonApi\Partner\V1\Employees\EmployeeRequest;
use App\JsonApi\Partner\V1\Employees\EmployeeSchema;
use App\Models\PartnerUser;
use App\Services\PartnerUserService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class EmployeeController extends Controller
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
    protected PartnerUserService $partnerService;


    public function __construct()
    {
        $this->partnerService = new PartnerUserService();
    }


    public function store(EmployeeSchema $schema, EmployeeRequest $request, EmployeeQuery $query)
    {
        $attributes = $request->data['attributes'];

        \Log::info($request->all());

        $dto = new PartnerUserDto(
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? 0,
            $attributes['partnerId'] ?? null,
        );

        $partner_user = $this->partnerService->create($dto);

        if(!$partner_user) return false;

        $partner_user = PartnerUser::find($partner_user->getKey());
        return new DataResponse($partner_user);
    }

    public function update(EmployeeSchema $schema, EmployeeRequest $request, EmployeeQuery $query, PartnerUser $partnerUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerUserDto(
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? 0,
            $attributes['partnerId'] ?? null,
        );

        $partner_user = $this->partnerService->update($dto, $partnerUser->id);

        if(!$partner_user) return false;

        $partner_user = PartnerUser::find($partner_user->getKey());
        return new DataResponse($partner_user);
    }

}
