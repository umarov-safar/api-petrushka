<?php

namespace App\Policies\Partner;

use App\JsonApi\Proxies\CompanyPartner as Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
       // return $user->isA('partner');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Company $company)
    {
        return $user->isA('partner');
    }

    /**
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function viewCompanyUsers(User $user, Company $company)
    {
        return true;
    }


    /**
     * @param User $user
     * @param Company $company
     *
     * @return bool
     */
    public function updateCompanyUsers(User $user, Company $company)
    {
        return true;
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return false;
        // return !$user->isBlock;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Company $company)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Company $company)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Company $company)
    {
        return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }
}
