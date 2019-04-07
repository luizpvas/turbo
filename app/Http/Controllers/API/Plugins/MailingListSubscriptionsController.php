<?php

namespace App\Http\Controllers\API\Plugins;

use App\Models\Plugins\MailingList;
use App\Http\Controllers\Controller;
use App\Models\Plugins\MailingListSubscription;

class MailingListSubscriptionsController extends Controller
{
    /**
     * POST /api/mailing_list_subscriptions
     * Attempts to create a subscription.
     *
     * @return Illuminate\Http\Response
     */
    function store()
    {
        request()->validate([
            'mailing_list_id' => 'required',
            'email' => 'required|email'
        ]);

        $mailingList = MailingList::findOrFail(request('mailing_list_id'));

        try {
            MailingListSubscription::create([
                'mailing_list_id' => $mailingList->id,
                'email' => request('email'),
                'attrs' => request()->except(['mailing_list_id', 'email'])
            ]);

            return $mailingList->subscribed_success_template;
        } catch(\Exception $e) {
            return $mailingList->already_subscribed_template;
        }
    }
}
