<?php
namespace App\Services;

use App\Models\CompanyUser;
use App\Models\User;

// DTOs
use App\Dtos\CompanyUserDto;
use App\Dtos\UserDto;

// Services
use App\Services\UserService;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CompanyUserService {

    /**
     * Create user company
     * @param CompanyUserDto $request
     * @return CompanyUser|false
     */
    public function create(CompanyUserDto $request)
    {
        /**
         * Алгоритм
         * 1. проверяем пользователя по номеру телефона;
         * 2. Пользователь есть
         *      2.1. проверяем его роли
         * 3. Пользователь не существует. Создаем пользователя.
         */

        $employeeUser = User::where('phone', $request->getPhone())->first();

        if($employeeUser) {
            if(Bouncer::is($employeeUser)->notAn('customer')){
                $employeeUser->assign('customer'); // привязать пользователя к роли "customer"
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
            $employeeUser->assign('customer'); // привязать пользователя к роли "customer"

        }

        // создаем сотрудника компании
        $companyUser = new CompanyUser();
        $companyUser->user_id = $employeeUser->id;
        $companyUser->company_id = $request->getCompanyId();
        $companyUser->phone = $request->getPhone();
        $companyUser->setting_info = $request->getSettingInfo();
        $companyUser->status = $request->getStatus();
        $companyUser->is_admin = $request->getIsAdmin();

        if(!$companyUser->save()) return false;

        $employeeUser->assign('customerEmployee'); // привязать пользователя к роли "customerEmployee"

        return $companyUser;
    }

    /**
     * Update user company
     * @param CompanyUserDto $request
     * @param int $id
     * @return CompanyUser|false
     */
    public function update(CompanyUserDto $request, int $id)
    {
        /**
         * Алгоритм
         * проверить при попытке разблокировки сотрудника
         * если сотрудник уже где-то привязан и там активен, то разблокировать его уже нельзя
         */
        $companyUser = CompanyUser::find($id);
        $companyUser->setting_info = $request->getSettingInfo();

        //$unsetRole = false;
        //$setRole = false;
        // Попытка разблокировки пользователя
        /*if($companyUser->status == CompanyUser::BLOCK_YES &&
            $request->getStatus() == CompanyUser::BLOCK_NO){
          // проверяем, есть ли у него роль customerEmployee, что означает, что этот сотрудник еще где является
          // активным сотрудником в другой компании
            if(Bouncer::is($companyUser->user)->notAn('customerEmployee')){
                $companyUser->status = $request->getStatus();
                $setRole = true;
            } else {
                // значит сотрудник уже привязан и активен в другой компании
                return false;
            }
        }*/
        //var_dump($setRole);

        // при блокировке пользователя
        /*if($companyUser->status == CompanyUser::BLOCK_NO &&
            $request->getStatus() == CompanyUser::BLOCK_YES){
            $companyUser->status = $request->getStatus();
            $unsetRole = true;
        }*/

        //var_dump($unsetRole);
        //exit;

        $companyUser->status = $request->getStatus();
        //$companyUser->is_admin = $request->getIsAdmin();

        if(!$companyUser->save()) return false;

        /*if($unsetRole){
            $companyUser->user->retract('customerEmployee'); // отвязать роль
        }

        if($setRole){
            $companyUser->user->assign('customerEmployee'); // привязать роль роль
        }*/

        return $companyUser;
    }

    // удаление сотрудника - это блокировка этого сотрудника в этой компании

}
