<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\EnabledPlugin;
use Illuminate\Http\Request;

class EnabledPluginsController extends Controller
{
    /**
     * POST /websites/{website}/enabled_plugins
     * Enables the plugin the website.
     *
     * @return Illuminate\Http\Response
     */
    function store(Website $website)
    {
        request()->validate([
            'plugin_class' => 'required'
        ]);

        $enabledPlugin = $website->enablePlugin(request('plugin_class'));

        return js_redirect(
            $enabledPlugin->rootPath($website)
        );
    }

    /**
     * DELETE /websites/{website}/enabled_plugins/{enabled_plugin}
     * Disables the plugin from the website.
     *
     * @param  Website       $website        Current website
     * @param  EnabledPlugin $enabled_plugin Plugin to be disabled
     * @return Illuminate\Http\Response
     */
    function destroy(Website $website, EnabledPlugin $enabled_plugin)
    {
        $website->disablePlugin($enabled_plugin->plugin_class);

        return js_redirect(
            route('websites.plugins.index', $website)
        );
    }
}
