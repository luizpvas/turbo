<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class PluginsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website']);
    }

    /**
     * GET /websites/{website}/plugins
     * Lists enabled plugins.
     *
     * @param  Website $website Current website
     * @return Illuminate\Http\Response
     */
    function index(Website $website)
    {
        $plugins = $website->enabledPlugins;

        if($plugins->count() == 0) {
            return redirect()->route('websites.plugins.create', $website);
        }

        return view('plugins.index', compact('website', 'plugins'));
    }

    /**
     * GET /websites/{website}/plugins/create
     * Renders the new plugin form.
     *
     * @param  Website $website Current website
     * @return Illuminate\Http\Response
     */
    function create(Website $website)
    {
        add_plugins_sheet();

        $availablePlugins = \App\Plugins\Kernel::availablePlugins();

        return view('plugins.create', compact('website', 'availablePlugins'));
    }
}
