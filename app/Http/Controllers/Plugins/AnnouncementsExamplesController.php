<?php

namespace App\Http\Controllers\Plugins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementsExamplesController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\Announcement']);
    }

    function index()
    {
        add_plugins_sheet();
        add_announcements_sheet();

        if (request('view')) {
            add_sheet(__('Examples'), route('websites.announcements_examples.index', website()));
        }

        return view('plugins.announcements_examples.index');
    }
}
