<?php

namespace App\Http\Controllers\Plugins;

use App\Models\Website;
use App\Models\Plugins\MailingList;
use App\Http\Controllers\Controller;

class MailingListsController extends Controller
{
    /**
     * Builds the middleware.
     */
    function __construct()
    {
        $this->middleware(['auth', 'auth.website', 'plugin:App\Plugins\MailingList']);
    }

    function index()
    {
        add_plugins_sheet();

        $mailingLists = MailingList::fromWebsite(website())
            ->withCount('subscriptions')
            ->paginate(20);

        return view('plugins.mailing_lists.index', compact('mailingLists'));
    }

    function create()
    {
        add_plugins_sheet();
        add_mailing_lists_sheet();

        $mailingList = new MailingList();
        return view('plugins.mailing_lists.create', compact('mailingList'));
    }

    function store()
    {
        $validatedData = request()->validate([
            'name' => 'required',
        ]);

        $mailingList = MailingList::create(array_merge($validatedData, [
            'website_id' => website()->id,
            'creator_id' => auth()->id()
        ]));

        return js_redirect(route('websites.mailing_lists.show', [website(), $mailingList]))
            ->flashSuccess(__('Mailing list created with success!'));
    }

    function show(Website $website, MailingList $mailing_list)
    {
        add_plugins_sheet();
        add_mailing_lists_sheet();

        $mailingList = $mailing_list;

        $subscriptions = $mailingList->subscriptions()
            ->latest()
            ->paginate(20);
        
        return view('plugins.mailing_lists.show', compact('mailingList', 'subscriptions'));
    }

    function edit(Website $website, MailingList $mailing_list)
    {
        add_plugins_sheet();
        add_mailing_lists_sheet();
        add_mailing_list_sheet($mailing_list);

        $mailingList = $mailing_list;
        return view('plugins.mailing_lists.edit', compact('mailingList'));
    }

    function update(Website $website, MailingList $mailing_list)
    {
        $validatedData = request()->validate([
            'name' => 'required',
            'subscribed_success_template' => 'required',
            'already_subscribed_template' => 'required'
        ]);

        $mailing_list->update($validatedData);

        return js_redirect(route('websites.mailing_lists.show', [$website, $mailing_list]))
            ->flashSuccess(__('Mailing list updated with success!'));
    }

    function destroy(Website $website, MailingList $mailing_list)
    {
        $mailing_list->delete();

        return js_redirect(route('websites.mailing_lists.index', website()))
            ->flashSuccess(__('Mailing removed with success!'));
    }
}
