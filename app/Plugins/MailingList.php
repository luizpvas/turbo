<?php

namespace App\Plugins;

class MailingList implements Plugin
{
    /**
     * Returns the plugin name, localized to the current
     * user.
     *
     * @return string
     */
    function name()
    {
        return __('Mailing list');
    }

    /**
     * Returns the plugin description, localized to the
     * current user.
     *
     * @return string
     */
    function description()
    {
        return __('Newsletter through email subscription.');
    }

    /**
     * Returns the root path to manage this plugin.
     *
     * @param  App\Models\Website $website Current website.
     * @return string
     */
    function rootPath($website)
    {
        return route('websites.mailing_lists.index', $website);
    }

    /**
     * Callback called when the plugin is enabled.
     *
     * @param  App\Models\Website $website Current website
     * @return void
     */
    function enable($website)
    {
        // Maybe create a default mailing list?
    }

    /**
     * Maybe runs the given at-call.
     *
     * @param  mixed             $call   Parsed at-call.
     * @param  App\Models\Render $render Render instance.
     * @return mixed
     */
    function runCall($call, $render)
    {
        switch($call['call']) {
        case 'mailing-list-form':
            $render->peek('end-mailing-list-form');
            return '<form data-controller="mailing-list" data-mailing-list-id="' . $call['params'][0] . '">';
        case 'end-mailing-list-form':
            return '</form>';
        }
    }
}
