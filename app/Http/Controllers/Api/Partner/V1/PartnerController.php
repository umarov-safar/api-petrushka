<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\PartnerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Partners\PartnerQuery;
use App\JsonApi\Admin\V1\Partners\PartnerRequest;
use App\JsonApi\Admin\V1\Partners\PartnerSchema;
use App\Models\Partner;
use App\JsonApi\Proxies\PartnerPartner as PartnerPartner; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Services\PartnerService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class PartnerController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
//    use Actions\UpdateRelationship;
//    use Actions\AttachRelationship;
//    use Actions\DetachRelationship;

    /**
     * @var PartnerService
     */
    protected PartnerService $partnerService;


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

        $dto = new PartnerDto(
            $attributes['name'] ?? '',
            $attributes['info'] ?? null,
            $attributes['isBlock'] ?? Partner::BLOCK_NO,
            $attributes['phone'],
        );

        $partner = $this->partnerService->create($dto);

        if(!$partner){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner = Partner::find($partner->getKey());
        $partner = new PartnerPartner($partner);
        return new DataResponse($partner);
    }

    /**
     * Update partner
     * @param PartnerSchema $schema
     * @param PartnerRequest $request
     * @param PartnerQuery $query
     * @param PartnerPartner $partner
     * @return false|DataResponse
     */

    public function update(PartnerSchema $schema, PartnerRequest $request, PartnerQuery $query, PartnerPartner $partner)
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerDto(
            $attributes['name'] ?? $partner->name,
            $attributes['info'] ?? $partner->info,
            $attributes['isBlock'] ?? $partner->is_block,
            $partner->phone, //$attributes['phone'],  Запрещено менять номер телефона
        );

        $partner = $this->partnerService->update($dto, $partner->id);

        if(!$partner){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner = Partner::find($partner->getKey());
        $partner = new PartnerPartner($partner);
        return new DataResponse($partner);
    }

    /**
     * Удаление существующего ресурса. Замена на блокировку партнера.
     *
     * @param PartnerRequest $request
     * @param Partner $user
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(PartnerRequest $request, Partner $partner)
    {
        //var_dump($user->roles());
        //exit;
        $dto = new PartnerDto(
            $partner->name,
            $partner->info,
            Partner::BLOCK_YES,
            $partner->phone,
        );

        $partner = $this->partnerService->update($dto, $partner->id);

        if(!$partner){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner = Partner::find($partner->getKey());
        return new DataResponse($partner);
    }
}
