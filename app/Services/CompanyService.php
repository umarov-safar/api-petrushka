<?php
namespace App\Services;

use App\Dtos\CompanyDto;
use App\Models\Company;

class CompanyService {

    /**
     * Create company
     * @param CompanyDto $request
     * @return Company|false
     */
    public function create(CompanyDto $request)
    {
        $company = new Company();

        $company->inn = $request->getInn();
        $company->info = $request->getInfo();
        $company->is_block = $request->isBlock();
        $company->admin_user_id = $request->getAdminUserId();

        if(!$company->save()) return false;

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
        $company->admin_user_id = $request->getAdminUserId();

        if(!$company->save()) return false;

        return $company;
    }
}
