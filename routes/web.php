<?php

Route::domain(config('app.host'))->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('/');

    Auth::routes();

    // Core features
    Route::resource('websites', 'WebsitesController');
    Route::resource('websites.plugins', 'PluginsController');
    Route::resource('websites.enabled_plugins', 'EnabledPluginsController');
    Route::resource('websites.attachments', 'AttachmentsController')->only(['index', 'store']);
    Route::resource('websites.deployment_settings', 'DeploymentSettingsController')->only(['index']);

    // Blog
    Route::resource('websites.blog_posts', 'Plugins\BlogPostsController');
    Route::resource('websites.blog_engines', 'Plugins\BlogEnginesController')->only(['edit', 'update']);
    Route::resource('websites.blog_examples', 'Plugins\BlogExamplesController')->only(['index']);

    // Announcements
    Route::resource('websites.announcements', 'Plugins\AnnouncementsController');
    Route::resource('websites.announcements_examples', 'Plugins\AnnouncementsExamplesController')->only(['index']);

    // Mailing lists
    Route::resource('websites.mailing_lists', 'Plugins\MailingListsController');
    Route::resource('websites.mailing_list_examples', 'Plugins\MailingListExamplesController');
});

Route::domain('{domain}')->group(function () {
    Route::any('{path}', 'TemplatesController@index')->where('path', '([\w\/\+\_\-]+)?');
});
