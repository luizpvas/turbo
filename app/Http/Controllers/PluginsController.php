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
        $availablePlugins = \App\Plugins\Kernel::availablePlugins();

        add_sheet(
            __(':website\'s plugins', ['website' => $website->name]),
            route('websites.plugins.index', $website)
        );

        return view('plugins.create', compact('website', 'availablePlugins'));
    }
}
