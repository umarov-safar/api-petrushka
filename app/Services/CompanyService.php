<?php
namespace App\Services;

use App\Dtos\CompanyDto;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

// DTOs
use App\Dtos\CompanyUserDto;
use App\Dtos\UserDto;

// Services
use App\Services\CompanyUserService;
use App\Services\UserService;

class CompanyService {

    /**
     * Create company
     * @param CompanyDto $request
     * @return Company|false
     */
    public function create(CompanyDto $request)
    {
        /**
         * Компанию может создать только тот у кого есть разрешение на создании компаний
         *
         * Админом компании может быть только пользователь, которые еще не является админом компании или сотрудником
         *
         * Алгоритм:
         * 1. проверяем по номеру телефона существование пользователя;
         * 2. пользователеь существует. Проверяем его роли.
         * 3. Пользователь не существует.
         */


        //$admin_user = User::firstOrCreate(['phone' => $request->getPhone()]); // тут не правильно совсем, идет обращение к модели, а не к методу сервиса
        $adminUser = User::where('phone', $request->getPhone())->first();
        // получить пользователя по номер телефона
        if($adminUser){
            if(Bouncer::is($adminUser)->notAn('customerAdmin', 'customerEmployee')){
                $adminUser->assign('customer'); // привязать пользователя к роли "customer"
                $adminUser->assign('customerAdmin'); // привязать пользователя к роли "customerAdmin"
            } else{
                // запретить создавать компанию, т.к. пользователь уже является админом в другой компании или является сотрудником
                return false;
            }
        } else {
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
            if(!$adminUser = $userService->create($dto));
                return false;
        }

        $company = new Company();
        $company->inn = $request->getInn();
        $company->info = $request->getInfo();
        $company->is_block = $request->isBlock();
        $company->phone = $request->getPhone();
        $company->admin_user_id = $adminUser->id;

        if(!$company->save()) return false;

        // создание записи в customer_user с пометкой, что user админ
        $dto = new CompanyUserDto(
            $company->id,
            $adminUser->phone,
            [],
            CompanyUser::BLOCK_NO,
            CompanyUser::IS_ADMIN_YES
        );
        $companyUserService = new CompanyUserService();
        $companyUser = $companyUserService->create($dto);

        return $company;
    }

    /**
     * Update company data
     * @param CompanyDto $request
     * @param int $id
     * @return Company|false
     */
    public function update(CompanyDto $request, int $id)
    {
        $company = Company::find($id);

        $company->inn = $request->getInn();
        $company->info = $request->getInfo();
        $company->is_block = $request->isBlock();
        //$company->phone = $request->getPhone(); // Запрещено менять телефон

        if(!$company->save()) return false;

        return $company;
    }
}
