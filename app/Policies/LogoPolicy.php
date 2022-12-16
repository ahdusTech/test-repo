<?php

namespace App\Policies;

use App\Logo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Logo  $logo
     * @return mixed
     */
    public function view(User $user, Logo $logo)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Logo  $logo
     * @return mixed
     */
    public function update(User $user, Logo $logo)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Logo  $logo
     * @return mixed
     */
    public function delete(User $user, Logo $logo)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Logo  $logo
     * @return mixed
     */
    public function restore(User $user, Logo $logo)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Logo  $logo
     * @return mixed
     */
    public function forceDelete(User $user, Logo $logo)
    {
        return true;
    }
}
