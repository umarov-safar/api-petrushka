<?php

namespace App\Policies\Customer;

//use App\Models\Partner;
use App\JsonApi\Proxies\MyCompanyCustomer as Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyCompanyPolicy
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
        return $user->isA('customer');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param Company $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Company $company)
    {
        return $user->isA('customer');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isA('customer');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Company  $company)
    {
        // и если есть право
        // и если является админом
        //dd($partner);
        //exit;
        return  $user->id == $company->admin_user_id && $user->isA('customer', 'customerAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Company  $company)
    {
        return false;
        //return  $user->id == $company->admin_user_id && $user->isA('customer', 'customerAdmin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Company  $company)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Company  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Company  $company)
    {
        return false;
    }
}
