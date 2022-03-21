<?php

namespace App\Policies\Partner;

use App\JsonApi\Proxies\PartnerUserPartner as PartnerUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerUserPolicy
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
        return true;
       // return $user->isA('partner');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User $user
     * @param  PartnerUser $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PartnerUser $partner)
    {
        return $user->isA('partner');
    }

    /**
     * @param  User $user
     * @param  PartnerUser $partner
     * @return bool
     */
    public function viewCompanyUsers(User $user, PartnerUser $partner)
    {
        return true;
    }


    /**
     * @param  User $user
     * @param  PartnerUser $partner
     *
     * @return bool
     */
    public function updatePartnerUsers(User $user, PartnerUser $partner)
    {
        return true;
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
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
     * @param  User $user
     * @param  PartnerUser $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PartnerUser $partner)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User $user
     * @param  PartnerUser $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PartnerUser $partner)
    {
        return false;
        // return $user->id == $company->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User $user
     * @param  PartnerUser $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PartnerUser $partner)
    {
        return $user->id == $partner->admin_user_id || $user->isA('superadmin', "admin");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User $user
     * @param  PartnerUser $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PartnerUser $partner)
    {
        //
    }
}
