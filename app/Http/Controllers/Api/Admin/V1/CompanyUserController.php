<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\CompanyUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserQuery;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserRequest;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserSchema;
use App\Models\CompanyUser;
use App\Models\User;
use App\Services\CompanyUserService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class CompanyUserController extends Controller
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
     * @var CompanyUserService
     */
    protected CompanyUserService $companyUserService;


    public function __construct()
    {
        $this->companyUserService = new CompanyUserService();
    }


    public function store(CompanyUserSchema $schema, CompanyUserRequest $request, CompanyUserQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyUserDto(
            $attributes['companyId'],
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? CompanyUser::BLOCK_NO,
            CompanyUser::IS_ADMIN_NO
        );

        $company_user = $this->companyUserService->create($dto);

        if(!$company_user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company_user = CompanyUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }


    public function update(CompanyUserSchema $schema, CompanyUserRequest $request, CompanyUserQuery $query, CompanyUser $companyUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyUserDto(
            //$attributes['companyId'],
            $companyUser->company_id,
            $companyUser->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? CompanyUser::BLOCK_NO,
            $companyUser->is_admin
        );

        $company_user = $this->companyUserService->update($dto, $companyUser->id);

        if(!$company_user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company_user = CompanyUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }

    /**
     * Удаление существующего ресурса. Замена на блокирвку пользователя.
     *
     * @param CompanyUserRequest $request
     * @param CompanyUser $user
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(CompanyUserRequest $request, CompanyUser $companyUser)
    {
        //var_dump($user->roles());
        //exit;

        $dto = new CompanyUserDto(
        //$attributes['companyId'],
            $companyUser->company_id,
            $companyUser->phone, //  Запрещено менять номер телефона
            $companyUser->setting_info,
            CompanyUser::BLOCK_YES,
            $companyUser->is_admin
        );



        $companyUser = $this->companyUserService->update($dto, $companyUser->id);

        if(!$companyUser) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $companyUser = CompanyUser::find($companyUser->getKey());
        return new DataResponse($companyUser);
    }

}
