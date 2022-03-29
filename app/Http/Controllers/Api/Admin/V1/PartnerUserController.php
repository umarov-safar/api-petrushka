<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\PartnerUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\PartnerUsers\PartnerUserQuery;
use App\JsonApi\Admin\V1\PartnerUsers\PartnerUserRequest;
use App\JsonApi\Admin\V1\PartnerUsers\PartnerUserSchema;
use App\Models\PartnerUser;
use App\Models\User;
use App\Services\PartnerUserService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class PartnerUserController extends Controller
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

        $dto = new PartnerUserDto(
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? PartnerUser::BLOCK_NO,
            PartnerUser::IS_ADMIN_NO,
            $attributes['partnerId'],
        );

        $partner_user = $this->partnerUserService->create($dto);

        if(!$partner_user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner_user = PartnerUser::find($partner_user->getKey());
        return new DataResponse($partner_user);
    }


    public function update(PartnerUserSchema $schema, PartnerUserRequest $request, PartnerUserQuery $query, PartnerUser $partnerUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerUserDto(
            $partnerUser->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? PartnerUser::BLOCK_NO,
            $partnerUser->is_admin,
            $partnerUser->partner_id,
        );

        $partner_user = $this->partnerUserService->update($dto, $partnerUser->id);

        if(!$partner_user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner_user = PartnerUser::find($partner_user->getKey());
        return new DataResponse($partner_user);
    }

    /**
     * Удаление существующего ресурса. Замена на блокировку пользователя.
     *
     * @param PartnerUserRequest $request
     * @param PartnerUser $partnerUser
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(PartnerUserRequest $request, PartnerUser $partnerUser)
    {
        //var_dump($user->roles());
        //exit;

        $dto = new PartnerUserDto(
        //$attributes['companyId'],
            $partnerUser->phone, //  Запрещено менять номер телефона
            $partnerUser->setting_info,
            PartnerUser::BLOCK_YES,
            $partnerUser->is_admin,
            $partnerUser->partner_id,
        );

        $partnerUser = $this->partnerUserService->update($dto, $partnerUser->id);

        if(!$partnerUser) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $companyUser = PartnerUser::find($partnerUser->getKey());
        return new DataResponse($partnerUser);
    }

}
