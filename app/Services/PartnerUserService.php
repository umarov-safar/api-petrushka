<?php
namespace App\Services;


use App\Models\PartnerUser;
use App\Models\User;

// DTOs
use App\Dtos\PartnerUserDto;
use App\Dtos\UserDto;

// Services
use App\Services\UserService;
use Silber\Bouncer\BouncerFacade as Bouncer;

class PartnerUserService {

    /**
     * Create user partner
     * @param PartnerUserDto $request
     * @return PartnerUser|false
     */
    public function create(PartnerUserDto $request)
    {

        $employeeUser = User::where('phone', $request->getPhone())->first();

        if($employeeUser) {
            if(Bouncer::is($employeeUser)->notAn('partnerEmployee')){
                $employeeUser->assign('partner'); // привязать пользователя к роли "partner"
                $employeeUser->assign('partnerEmployee'); // привязать пользователя к роли "partnerEmployee"
            } else{
                // запретить создавать компанию, т.к. пользователь уже является сотрудником в другой компании или является сотрудником
                return false;
            }
        } else {
            // создать пользователя
            // создать пользователя и выставить ему роль customerAdmin
            $dto = new UserDto(
                null,
                null,
                User::BLOCK_NO,
                $request->getPhone(),
                null,
                null,
                null
            );
            $userService = new UserService();
            if(!$employeeUser = $userService->create($dto))
                return false;
            $employeeUser->assign('partner'); // привязать пользователя к роли "partner"
            $employeeUser->assign('partnerEmployee'); // привязать пользователя к роли "partnerEmployee"
        }

        $partner_user = new PartnerUser();
        $partner_user->user_id = $employeeUser->id;
        $partner_user->partner_id = $request->getPartnerId() ?? auth()->user()->partnerOwner->id;
        $partner_user->phone = $request->getPhone();
        $partner_user->setting_info = $request->getSettingInfo();
        $partner_user->status = $request->getStatus();
        $partner_user->is_admin = $request->getIsAdmin();

        if(!$partner_user->save()) return false;

        return $partner_user;
    }

    /**
     * Update user partner
     * @param PartnerUserDto $request
     * @param int $id
     * @return PartnerUser|false
     */
    public function update(PartnerUserDto $request, int $id)
    {
        $partnerUser = PartnerUser::find($id);

        // $partner_user->phone = $request->getPhone();
        $partnerUser->setting_info = $request->getSettingInfo();

        $unsetRole = false;
        $setRole = false;

        // Попытка разблокировки пользователя
        if($partnerUser->status == PartnerUser::BLOCK_YES &&
            $request->getStatus() == PartnerUser::BLOCK_NO){
            // проверяем, есть ли у него роль customerEmployee, что означает, что этот сотрудник еще где является
            // активным сотрудником в другой компании
            if(Bouncer::is($partnerUser->user)->notAn('partnerEmployee')){
                $partnerUser->status = $request->getStatus();
                $setRole = true;
            } else {
                // значит сотрудник уже привязан и активен в другой компании
                return false;
            }
        }
        //var_dump($setRole);

        // при блокировке пользователя
        if($partnerUser->status == PartnerUser::BLOCK_NO &&
            $request->getStatus() == PartnerUser::BLOCK_YES){
            $partnerUser->status = $request->getStatus();
            $unsetRole = true;
        }

        $partnerUser->status = $request->getStatus();
        // $partner_user->is_admin = $request->getIsAdmin();

        if(!$partnerUser->save()) return false;

        if($unsetRole){
            $partnerUser->user->retract('partnerEmployee'); // отвязать роль
        }

        if($setRole){
            $partnerUser->user->assign('partnerEmployee'); // привязать роль роль
        }

        return $partnerUser;
    }

}
