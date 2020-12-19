<?php

namespace Task\Policies;

use Task\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user) {
        return $user->admin;
    }

    public function show(User $requestUser, User $user) {
        return $requestUser->admin || $requestUser->id === $user->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \Task\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \Task\User  $user
     * @param  \Task\User  $user
     * @return mixed
     */
    public function update(User $requestUser, User $user)
    {
        return $requestUser->admin;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \Task\User  $user
     * @param  \Task\User  $user
     * @return mixed
     */
    public function delete(User $requestUser, User $user)
    {
        return $requestUser->admin;
    }
}
