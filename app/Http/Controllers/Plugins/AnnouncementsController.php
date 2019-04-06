<?php

namespace App\Http\Controllers\Plugins;

use App\Models\Website;
use App\Models\Plugins\Announcement;
use App\Http\Controllers\Controller;

class AnnouncementsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\Announcement']);
    }

    /**
     * GET /websites/{website}/announcements
     * Renders the announcements.
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        $announcements = Announcement::fromWebsite(website())
            ->latest()
            ->paginate(20);

        add_plugins_sheet();

        return view('plugins.announcements.index', compact('announcements'));
    }

    /**
     * GET /websites/{website}/announcements/create
     * Renders the announcements.
     *
     * @return Illuminate\Http\Response
     */
    function create()
    {
        add_plugins_sheet();
        add_announcements_sheet();

        $announcement = new Announcement();
        return view('plugins.announcements.create', compact('announcement'));
    }

    function store()
    {
        $validatedData = request()->validate([
            'title' => 'required',
            'body_html' => 'required',
            'body_text' => 'required',
            'is_highlighted' => 'nullable'
        ]);

        $announcement = Announcement::create(array_merge($validatedData, [
            'author_id' => auth()->id(),
            'website_id' => website()->id,
        ]));

        return js_redirect(route('websites.announcements.index', website()))
            ->flashSuccess(__('Announcement created with success!'));
    }

    function edit(Website $website, Announcement $announcement)
    {
        add_plugins_sheet();
        add_announcements_sheet();

        return view('plugins.announcements.edit', compact('announcement'));
    }

    function update(Website $website, Announcement $announcement)
    {
        $validatedData = request()->validate([
            'title' => 'sometimes|required',
            'body_html' => 'sometimes|required',
            'body_text' => 'sometimes|required',
            'is_highlighted' => 'nullable'
        ]);

        $announcement->update($validatedData);

        return js_redirect(
            route('websites.announcements.edit', [$website, $announcement])
        )->flashSuccess(__('Announcement updated with success!'));
    }

    function destroy(Website $website, Announcement $announcement)
    {
        $announcement->delete();

        return js_redirect(
            route('websites.announcements.index', $website)
        )->flashSuccess(__('Announcement deleted with success!'));
    }
}
