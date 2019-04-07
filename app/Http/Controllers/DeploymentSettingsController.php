<?php

namespace App\Http\Controllers;

use App\Models\Deployment;

class DeploymentSettingsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website']);
    }

    /**
     * GET /websites/{website}/deployment_settings
     * Renders the settings page.
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        $deployments = Deployment::fromWebsite(website())
            ->with('templates')
            ->latest()
            ->paginate(5);

        return view('deployment_settings.index', compact('deployments'));
    }
}
