<?php

Route::resource('deployments', 'DeploymentsController');

Route::post('mailing_list_subscriptions', 'API\Plugins\MailingListSubscriptionsController@store')
    ->name('api.mailing_list_subscriptions.store');
