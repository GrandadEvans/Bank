<?php

namespace Bank\Policies;

use Bank\Models\PossibleRegular;
use Bank\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PossibleRegularPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Bank\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Bank\Models\User  $user
     * @param  \Bank\Models\PossibleRegular  $possibleRegular
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PossibleRegular $possibleRegular)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Bank\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Bank\Models\User  $user
     * @param  \Bank\Models\PossibleRegular  $possibleRegular
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PossibleRegular $possibleRegular)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Bank\Models\User  $user
     * @param  \Bank\Models\PossibleRegular  $possibleRegular
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PossibleRegular $possibleRegular)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Bank\Models\User  $user
     * @param  \Bank\Models\PossibleRegular  $possibleRegular
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PossibleRegular $possibleRegular)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Bank\Models\User  $user
     * @param  \Bank\Models\PossibleRegular  $possibleRegular
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PossibleRegular $possibleRegular)
    {
        //
    }
}
