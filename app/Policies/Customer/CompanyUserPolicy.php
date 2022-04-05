<?php

namespace App\Policies\Customer;

use App\JsonApi\Proxies\CompanyUserCustomer as CompanyUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isA('customerAdmin');
       // return $user->isA('partner');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User $user
     * @param  CompanyUser $customerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CompanyUser $customerUser)
    {
        return $user->isA('customerAdmin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        /**
         * проверка на то что можно создавать сотрудника с привязкой к этому партнеру
         *
         * получить partnerId
         * получить partner
         */

        return $user->isA('customerAdmin');
        // return !$user->isBlock;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @param  CompanyUser $customerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CompanyUser $customerUser)
    {
        return $user->isA('customerAdmin');
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User $user
     * @param  CompanyUser $customerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CompanyUser $customerUser)
    {
        return $user->id != $customerUser->is_admin && $user->isA('customerAdmin');
        //return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User $user
     * @param  CompanyUser $customerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CompanyUser $customerUser)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User $user
     * @param  CompanyUser $customerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CompanyUser $customerUser)
    {
        return false;
    }
}
