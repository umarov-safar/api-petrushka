<?php
namespace App\Services;

use App\Dtos\CompanyDto;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

// DTOs
use App\Dtos\CompanyUserDto;

// Services
use App\Services\CompanyUserService;

class CompanyService {

    /**
     * Create company
     * @param CompanyDto $request
     * @return Company|false
     */
    public function create(CompanyDto $request)
    {
        $company = new Company();

        $admin_user = User::firstOrCreate(['phone' => $request->getPhone()]);
        if(Bouncer::is($admin_user)->notAn('customerAdmin', 'customerEmployee')){
            $admin_user->assign('customer'); // привязать пользователя к роли "partnerAdmin"
            $admin_user->assign('customerAdmin'); // привязать пользователя к роли "partnerAdmin"
        }

        $company->inn = $request->getInn();
        $company->info = $request->getInfo();
        $company->is_block = $request->isBlock();
        $company->phone = $request->getPhone();
        $company->admin_user_id = $admin_user->id;

        if(!$company->save()) return false;

        // создание записи в partner_user с пометкой, что user админ
        $dto = new CompanyUserDto(
            $company->id,
            $admin_user->phone,
            [],
            0,
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
        $company->phone = $request->getPhone();

        if(!$company->save()) return false;

        return $company;
    }
}
