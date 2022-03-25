<?php

namespace App\Policies\Partner;

//use App\Models\Partner;
use App\JsonApi\Proxies\PartnerPartner as Partner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
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
        return $user->isA('partner');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param Partner $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Partner $partner)
    {
        return $user->isA('partner');
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
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner  $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Partner $partner)
    {
        // и если есть право
        // и если является админом
        return  $user->id == $partner->admin_user_id && $user->isA('partner', 'partnerAdmin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner  $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Partner $partner)
    {
        return $user->isA('superadmin', 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner  $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Partner $partner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Partner  $partner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Partner $partner)
    {
        //
    }
}
