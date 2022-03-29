<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\PartnerUserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Employees\EmployeeQuery;
use App\JsonApi\Partner\V1\Employees\EmployeeRequest;
use App\JsonApi\Partner\V1\Employees\EmployeeSchema;
use App\Models\PartnerUser;
use App\JsonApi\Proxies\PartnerUserPartner as Employee; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Models\User as User;
use Auth;
use App\Services\PartnerUserService;
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
// use Actions\Destroy; Бл, Сафар. Мы же обсуждали, что удаления нет, просто меняется статус на "заблокирован"
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    protected PartnerUserService $partnerUserService;
    protected User $user;


    public function __construct()
    {
        $this->partnerUserService = new PartnerUserService();
        //$this->user = Auth::user();
    }

    protected function getUser(){
        $this->user = Auth::user();
    }


    public function store(EmployeeSchema $schema, EmployeeRequest $request, EmployeeQuery $query)
    {
        $attributes = $request->data['attributes'];
        //$this->getUser();
        //$partnerId = $this->user->partner->id;
        // нужно делать проверку на существование $partnerId ?

        //\Log::info($request->all());

        $dto = new PartnerUserDto(
            $attributes['phone'],
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? PartnerUser::BLOCK_NO,
            PartnerUser::IS_ADMIN_NO,
            $attributes['partnerId'], //$partnerId,
        );

        $partnerUser = $this->partnerUserService->create($dto);

        if(!$partnerUser){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partnerUser = PartnerUser::find($partnerUser->getKey());
        $employee = new Employee($partnerUser);
        return new DataResponse($employee);
    }

    public function update(EmployeeSchema $schema, EmployeeRequest $request, EmployeeQuery $query, Employee $partnerUser)
    {
        $attributes = $request->data['attributes'];
        //dump();
        //\Log::debug($partnerUser);

        $dto = new PartnerUserDto(
            $partnerUser->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $attributes['settingInfo'] ?? null,
            $attributes['status'] ?? PartnerUser::BLOCK_NO,
            $partnerUser->is_admin,
            $partnerUser->partner_id,
        );

        $partnerUser = $this->partnerUserService->update($dto, $partnerUser->id);

        if(!$partnerUser){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partnerUser = PartnerUser::find($partnerUser->getKey());
        $employee = new Employee($partnerUser);
        return new DataResponse($employee);
    }

    /**
     * Удаление существующего ресурса. Замена на блокировку пользователя.
     *
     * @param EmployeeRequest $request
     * @param Employee $partnerUser
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(EmployeeRequest $request, Employee $partnerUser)
    {
        //var_dump($user->roles());
        //exit;

        $dto = new PartnerUserDto(
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

        $partnerUser = PartnerUser::find($partnerUser->getKey());
        $employee = new Employee($partnerUser);
        return new DataResponse($employee);
    }

}
