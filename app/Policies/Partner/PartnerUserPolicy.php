<?php

namespace App\Policies\Partner;

use App\Models\Partner\PartnerUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerUserPolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partner\PartnerUser  $partnerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PartnerUser $partnerUser)
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partner\PartnerUser  $partnerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PartnerUser $partnerUser)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partner\PartnerUser  $partnerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PartnerUser $partnerUser)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partner\PartnerUser  $partnerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PartnerUser $partnerUser)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partner\PartnerUser  $partnerUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PartnerUser $partnerUser)
    {
        //
    }
}
