<?php

namespace App\Http\Controllers\Api\Customer\V1;

use App\Dtos\CompanyUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserQuery;
use App\JsonApi\Customer\V1\Employees\EmployeeRequest;
use App\JsonApi\Customer\V1\Employees\EmployeeSchema;
use App\Models\CompanyUser;
use App\JsonApi\Proxies\CompanyUserCustomer as Employee; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Services\CompanyUserService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class EmployeeController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//   use Actions\Destroy;
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


    public function store(EmployeeSchema $schema, EmployeeRequest $request, CompanyUserQuery $query)
    {
        $attributes = $request->data['attributes'];

        /**
         *  int $company_id,
        string $phone,
        ?array $setting_info,
        bool $status,
        bool $isAdmin
         */
        $dto = new CompanyUserDto(
            $attributes['companyId'],
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            CompanyUser::BLOCK_NO,
            CompanyUser::IS_ADMIN_NO
        );

        $companyUser = $this->companyUserService->create($dto);

        if(!$companyUser){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $companyUser = CompanyUser::find($companyUser->getKey());
        $employee = new Employee($companyUser);
        return new DataResponse($employee);
    }


    public function update(EmployeeSchema $schema, EmployeeRequest $request, CompanyUserQuery $query, Employee $companyUser)
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyUserDto(
            $companyUser->company_id,
            $companyUser->phone,
            $attributes['settingInfo'] ?? null,
            $companyUser->status,
            $companyUser->is_admin
        );

        $companyUser = $this->companyUserService->update($dto, $companyUser->id);

        if(!$companyUser){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $companyUser = CompanyUser::find($companyUser->getKey());
        $employee = new Employee($companyUser);
        return new DataResponse($employee);
    }

    /**
     * Удаление существующего ресурса. Замена на блокировку пользователя.
     *
     * @param EmployeeRequest $request
     * @param Employee $partnerUser
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(EmployeeRequest $request, Employee $companyUser)
    {
        //var_dump($user->roles());
        //exit;

        $dto = new CompanyUserDto(
            $companyUser->company_id, //  Запрещено менять номер телефона
            $companyUser->phone, //  Запрещено менять номер телефона
            $companyUser->setting_info,
            CompanyUser::BLOCK_YES,
            $companyUser->is_admin,
        );

        $companyUser = $this->companyUserService->update($dto, $companyUser->id);

        if(!$companyUser) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $companyUser = CompanyUser::find($companyUser->getKey());
        $employee = new Employee($companyUser);
        return new DataResponse($employee);
    }

}
