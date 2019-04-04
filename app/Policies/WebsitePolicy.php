<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Website;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebsitePolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the user can manage the website.
     *
     * @param App\Models\User    $user    Current user
     * @param App\Models\Website $website Current website
     *
     * @return boolean
     */
    function update(User $user, Website $website)
    {
        return $website->isOwner($user);
    }
}
