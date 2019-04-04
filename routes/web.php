<?php

Route::domain(config('app.host'))->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('/');

    Auth::routes();

    Route::resource('websites', 'WebsitesController');
    Route::resource('websites.plugins', 'PluginsController');
    Route::resource('websites.enabled_plugins', 'EnabledPluginsController');
    Route::resource('websites.blog_posts', 'Plugins\BlogPostsController');
    Route::resource('deployments', 'DeploymentsController');
});

Route::domain('{domain}')->group(function () {
    Route::any('{path}', 'TemplatesController@index')->where('path', '([\w\/\+\_\-]+)?');
});
