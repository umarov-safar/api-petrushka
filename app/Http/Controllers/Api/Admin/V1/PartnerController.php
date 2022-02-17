<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\Admin\PartnerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Partners\PartnerQuery;
use App\JsonApi\Admin\V1\Partners\PartnerRequest;
use App\JsonApi\Admin\V1\Partners\PartnerSchema;
use App\Models\Admin\Partner;
use App\Models\User;
use App\Services\Admin\PartnerService;
use JetBrains\PhpStorm\Pure;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class PartnerController extends Controller
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
     * @var PartnerService
     */
    protected PartnerService $partnerService;


    /**
     * @param PartnerService $partnerService
     */
    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }


    /**
     * Create partner
     * @param PartnerSchema $schema
     * @param PartnerRequest $request
     * @param PartnerQuery $query
     * @return false|DataResponse
     */
    public function store(PartnerSchema $schema, PartnerRequest $request, PartnerQuery $query)
    {
        $attributes = $request->data['attributes'];

        //get user by phone or create new to save id to user_admin_id field in partner table
        $user = User::firstOrCreate(['phone' => $attributes['phone']]);

        $dto = new PartnerDto(
            $attributes['name'],
            $attributes['phone'],
            $attributes['info'] ?? null,
            $attributes['isBlock'] ?? 0,
            $user->id,
        );

        $partner = $this->partnerService->create($dto);

        if(!$partner) return false;

        $partner = Partner::find($partner->getKey());
        return new DataResponse($partner);
    }

    /**
     * Update partner
     * @param PartnerSchema $schema
     * @param PartnerRequest $request
     * @param PartnerQuery $query
     * @param Partner $partner
     * @return false|DataResponse
     */

    public function update(PartnerSchema $schema, PartnerRequest $request, PartnerQuery $query, Partner $partner)
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerDto(
            $attributes['name'],
            $attributes['phone'],
            $attributes['info'] ?? null,
            $attributes['isBlock'] ?? 0,
            $partner->admin_user_id
        );

        $partner = $this->partnerService->update($dto, $partner->id);

        if(!$partner) return false;

        $partner = Partner::find($partner->getKey());
        return new DataResponse($partner);
    }
}
