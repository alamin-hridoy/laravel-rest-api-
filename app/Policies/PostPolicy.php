<?php

namespace Task\Policies;

use Task\User;
use Task\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \Task\User  $user
     * @param  \Task\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->admin || $user->ownsPost($post);
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \Task\User  $user
     * @param  \Task\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->admin || $user->ownsPost($post);
    }
}