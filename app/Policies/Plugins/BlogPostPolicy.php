<?php

namespace App\Policies\Plugins;

use App\Models\User;
use App\Models\Plugins\BlogPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user can update the blog post.
     *
     * @param User     $user Current user
     * @param BlogPost $post Current post
     *
     * @return boolean
     */
    function update(User $user, BlogPost $post)
    {
        return $post->website->isOwner($user);
    }
}
