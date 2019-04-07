<?php

namespace App\Http\Controllers\Plugins;

use App\Models\Plugins\MailingList;
use App\Http\Controllers\Controller;

class MailingListExamplesController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\MailingList']);
    }

    /**
     * GET /websites/{website}/mailing_list_examples
     * Renders the HTML snippets to help people with customizing their plugin.
     *
     * @return Illuminate\Http\Response
     */
    function index()
    {
        $mailingList = MailingList::findOrFail(request('mailing_list_id'));

        add_plugins_sheet();
        add_mailing_lists_sheet();
        add_mailing_list_sheet($mailingList);

        if (request('view')) {
            add_sheet(
                __('Examples'),
                route('websites.mailing_list_examples.index', [website(), 'mailing_list_id' => $mailingList->id])
            );
        }

        return view('plugins.mailing_list_examples.index', compact('mailingList'));
    }
}
