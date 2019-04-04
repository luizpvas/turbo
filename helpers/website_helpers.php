<?php

/**
 * Returns the current website from the request.
 * See `CurrentWebsite` middleware for details about
 * how the website is loaded.
 *
 * @return App\Models\Website
 */
function website()
{
    return request()->get('website');
}
