<?php

/**
 * Builds a turbolinks redirect.
 *
 * @param string $route  URL to redirect
 * @param string $action Advance or replace
 *
 * @return \App\Http\TurbolinksResponse
 */
function js_redirect($route, $action = 'replace')
{
    return new \App\Http\TurbolinksResponse($route, $action);
}
