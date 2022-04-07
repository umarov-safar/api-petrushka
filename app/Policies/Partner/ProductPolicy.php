<?php

namespace App\Policies\Partner;

use App\JsonApi\Proxies\ProductPartner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\ProductPartner  $productPartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProductPartner $productPartner)
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
        return $user->isA('partner');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\ProductPartner  $productPartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ProductPartner $productPartner)
    {
        if($user->isA('partner')) {
            $user = auth()->user();
            $partners = $user->partners()->forAdminUser($user->id)->get();
            if ($partners) {
                $partnersIds = $partners->pluck('id')->all() ?? [];
                return in_array($productPartner->partner_id, $partnersIds);
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\ProductPartner  $productPartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ProductPartner $productPartner)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\ProductPartner  $productPartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ProductPartner $productPartner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\ProductPartner  $productPartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ProductPartner $productPartner)
    {
        //
    }
}
