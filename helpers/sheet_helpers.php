<?php

/**
 * Appends a sheet to the stack.
 *
 * @param  string $label Sheet label
 * @param  string $route Sheet route
 * @return void
 */
function add_sheet($label, $route)
{
    global $_sheets;

    $_sheets[] = ['label' => $label, 'route' => $route];
}

/**
 * Add 'Plugins' to the sheets.
 *
 * @return void
 */
function add_plugins_sheet()
{
    add_sheet(__('Plugins'), route('websites.plugins.index', website()));
}

/**
 * Add 'Blog' to the sheets.
 *
 * @return void
 */
function add_blog_sheet()
{
    add_sheet(
        __('Blog'),
        route('websites.blog_posts.index', website())
    );
}

/**
 * Add 'Announcements' to the sheets.
 *
 * @return void
 */
function add_announcements_sheet()
{
    add_sheet(
        __('Announcements'),
        route('websites.announcements.index', website())
    );
}

/**
 * Add 'Mailing lists' to the sheets.
 *
 * @return void
 */
function add_mailing_lists_sheet()
{
    add_sheet(
        __('Mailing lists'),
        route('websites.mailing_lists.index', website())
    );
}

/**
 * Adds mailing sheet.
 *
 * @param  App\Models\Plugins\MailingList $mailingList Current mailing list
 * @return void
 */
function add_mailing_list_sheet($mailingList)
{
    add_sheet($mailingList->name, route('websites.mailing_lists.show', [website(), $mailingList]));
}


/**
 * Returns the list of sheeets, in order they were stacked.
 *
 * @return array
 */
function sheets()
{
    global $_sheets;
    return $_sheets ?? [];
}
