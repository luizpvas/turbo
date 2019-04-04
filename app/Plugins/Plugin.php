<?php

namespace App\Plugins;

interface Plugin
{
    /**
     * Returns the plugin name, localized to the current
     * user.
     *
     * @return string
     */
    function name();

    /**
     * Returns the plugin description, localized to the
     * current user.
     *
     * @return string
     */
    function description();

    /**
     * Returns the root path to manage this plugin.
     *
     * @param  App\Models\Website $website Current website.
     * @return string
     */
    function rootPath($website);

    /**
     * Maybe runs the given at-call.
     *
     * @param  mixed             $call   Parsed at-call.
     * @param  App\Models\Render $render Render instance.
     * @return mixed
     */
    function runCall($call, $render);
} 
