<?php

namespace App\Policies\Customer;

use App\JsonApi\Proxies\PartnerCustomer as Partner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
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
     * @param  Partner $partner
     * @return bool
     */
    public function view(User $user, Partner $partner)
    {
        return $user->isA('customer');
    }


    public function viewCategories(User $user): bool
    {
        return true;
    }


    public function viewProducts(User $user)
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
     * @param  Partner $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Partner $partner)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Partner $partner)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Partner $partner)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\CompanyPartner  $company
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Partner $partner)
    {
        return false;
    }
}
