<?php

namespace App\Http\Controllers;

use App\Models\Website;
use \App\Http\Requests\StoreWebsiteRequest;

class WebsitesController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * GET /websites
     * Lists websites the user is authorized to manage.
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        $websites = Website::authorized(auth()->user())->get();
        return view('websites.index', compact('websites'));
    }

    /**
     * GET /websites/create
     * Renders the website form.
     *
     * @return Illuminate\Http\Response
     */
    function create()
    {
        $website = new Website();
        add_sheet(__('Your websites'), route('websites.index'));
        return view('websites.create', compact('website'));
    }

    /**
     * POST /websites
     * Attempts to create a new website.
     *
     * @param  StoreWebsiteRequest $request HTTP request
     * @return Illuminate\Http\Response
     */
    function store(StoreWebsiteRequest $request)
    {
        $website = new Website($request->validated());
        $website->owner_id = auth()->id();
        $website->save();

        return js_redirect(route('websites.plugins.index', $website));
    }

    /**
     * GET /websites/{website}
     * Renders the website page.
     *
     * @param  Website $website Current website
     * @return Illuminate\Http\Response
     */
    function show(Website $website)
    {
        $this->authorize('update', $website);

        add_sheet(__('Your websites'), route('websites.index'));

        return view('websites.show', compact('website'));
    }
}
