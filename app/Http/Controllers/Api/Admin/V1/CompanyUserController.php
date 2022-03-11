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
use LaravelJsonApi\Core\Responses\DataResponse;
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
            $attributes['status'] ?? 0,
            0
        );

        $company_user = $this->companyUserService->create($dto);

        if(!$company_user) return false;

        $company_user = CompanyUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }


    public function update(CompanyUserSchema $schema, CompanyUserRequest $request, CompanyUserQuery $query, CompanyUser $companyUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyUserDto(
            $attributes['companyId'],
            $companyUser->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? 0,
            0
        );

        $company_user = $this->companyUserService->update($dto, $companyUser->id);

        if(!$company_user) return false;

        $company_user = CompanyUser::find($company_user->getKey());
        return new DataResponse($company_user);
    }

}
