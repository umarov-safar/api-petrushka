<?php
namespace App\Services;

use App\Dtos\CompanyDto;
use App\Models\Company;
use App\Models\User;

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

        $company->inn = $request->getInn();
        $company->info = $request->getInfo();
        $company->is_block = $request->isBlock();
        $company->phone = $request->getPhone();
        $company->admin_user_id = $admin_user->id;

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
        $company->phone = $request->getPhone();

        if(!$company->save()) return false;

        return $company;
    }
}
