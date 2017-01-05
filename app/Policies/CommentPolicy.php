<?php

namespace moum\Policies;

use moum\User;
use moum\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \moum\User  $user
     * @param  \moum\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \moum\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \moum\User  $user
     * @param  \moum\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \moum\User  $user
     * @param  \moum\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        //
    }
}
