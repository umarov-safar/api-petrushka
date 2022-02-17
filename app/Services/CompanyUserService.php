<?php
namespace App\Services;

use App\Dtos\CompanyUserDto;
use App\Models\CompanyUser;

class CompanyUserService {

    /**
     * Create user company
     * @param CompanyUserDto $request
     * @return CompanyUser|false
     */
    public function create(CompanyUserDto $request)
    {
        $company_user = new CompanyUser();

        $company_user->user_id = $request->getUserId();
        $company_user->company_id = $request->getCompanyId();
        $company_user->phone = $request->getPhone();
        $company_user->setting_info = $request->getSettingInfo();
        $company_user->status = $request->isStatus();

        if(!$company_user->save()) return false;

        return $company_user;
    }

    /**
     * Update user company
     * @param CompanyUserDto $request
     * @param int $id
     * @return false
     */
    public function update(CompanyUserDto $request, int $id)
    {
        $company_user = CompanyUser::find($id);

        $company_user->user_id = $request->getUserId();
        $company_user->company_id = $request->getCompanyId();
        $company_user->phone = $request->getPhone();
        $company_user->setting_info = $request->getSettingInfo();
        $company_user->status = $request->isStatus();

        if(!$company_user->save()) return false;

        return $company_user;
    }

}
