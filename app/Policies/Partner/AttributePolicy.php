<?php

namespace App\Policies\Partner;

use App\JsonApi\Proxies\AttributePartner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
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
     * @param  \App\JsonApi\Proxies\AttributePartner  $attributePartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AttributePartner $attributePartner)
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
     * @param  \App\JsonApi\Proxies\AttributePartner  $attributePartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AttributePartner $attributePartner)
    {
        if($user->isA('partner')) {
            $user = auth()->user();
            $partners = $user->partners()->forAdminUser($user->id)->get();
            if ($partners) {
                $partnersIds = $partners->pluck('id')->all() ?? [];

                return in_array($attributePartner->partner_id, $partnersIds);
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\AttributePartner  $attributePartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AttributePartner $attributePartner)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\AttributePartner  $attributePartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AttributePartner $attributePartner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JsonApi\Proxies\AttributePartner  $attributePartner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AttributePartner $attributePartner)
    {
        //
    }
}
