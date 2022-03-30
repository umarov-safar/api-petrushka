<?php

namespace App\Policies;

use App\Models\Attribute;
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
        return $user->isA('partner') || $user->isA('admin', 'superadmin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Attribute $attribute)
    {
        return $user->isA('partner') || $user->isA('admin', 'superadmin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isA('partner') || $user->isA('admin', 'superadmin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Attribute $attribute)
    {
        return ($user->isA('partner') && $user->partnerOwner->id === $attribute->partner_id) || $user->isA('admin', 'superadmin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Attribute $attribute)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Attribute $attribute)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Attribute $attribute)
    {
        //
    }
}
