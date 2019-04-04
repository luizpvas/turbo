<?php

namespace App\Plugins;

class Announcement implements Plugin
{
    /**
     * Returns the plugin name, localized to the current
     * user.
     *
     * @return string
     */
    function name()
    {
        return __('Announcements');
    }

    /**
     * Returns the plugin description, localized to the
     * current user.
     *
     * @return string
     */
    function description()
    {
        return __('Short announcements with an optional highlight one.');
    }

    /**
     * Returns the root path to manage this plugin.
     *
     * @param  App\Models\Website $website Current website.
     * @return string
     */
    function rootPath($website)
    {
        return route('websites.blog_posts.index', $website);
    }

    /**
     * Maybe runs the given at-call.
     *
     * @param  mixed             $call   Parsed at-call.
     * @param  App\Models\Render $render Render instance.
     * @return mixed
     */
    function runCall($call, $render)
    {
        switch ($call['call']) {
        case 'announcements-paginated-list':
            $render->peek('end-announcements-paginated-list');
            return '<?php foreach(\App\Plugins\Announcement::paginatedList() as $item) { ?>';
        case 'end-announcements-paginated-list':
            return '<?php } ?>';
        case 'announcement-list-item-title':
            return '<?= $item->title ?>';
        case 'announcement-list-item-body':
            return '<?= $item->body ?>';
        case 'announcement-has-highlighted':
            $render->peek('end-announcement-has-highlighted');
            return '<?php if('.bool_expr(self::getHighlightedAnnouncementFromRequest()).') { ?>';
        case 'end-announcement-has-highlighted':
            return '<?php } ?>';
        case 'announcement-highlighted-title':
            return '<?= \App\Plugins\Announcement::getHighlightedAnnouncementFromRequest("title") ?>';
        case 'announcement-highlighted-body':
            return '<?= \App\Plugins\Announcement::getHighlightedAnnouncementFromRequest("body") ?>';
        default:
            return null;
        }
    }

    /**
     * Fetches the blog post record from the request.
     *
     * @param  string|null $attr Attribute from the record.
     * @return App\Models\Plugins\BlogPost
     */
    static function getHighlightedAnnouncementFromRequest($attr = null)
    {
        if ($announcement = request()->get('highlightedAnnouncement')) {
            return is_null($attr) ? $announcement : ($announcement->$attr ?? '');
        }

        $announcement = \App\Models\Plugins\Announcement::fromWebsite(website())
            ->isHighlighted()
            ->first();

        request()->attributes->set('highlightedAnnouncement', $announcement);

        return is_null($attr) ? $announcement : ($announcement->$attr ?? '');
    }

    /**
     * Paginates the latest announcements of the website.
     *
     * @return mixed
     */
    static function paginatedList()
    {
        return once(function () {
            return \App\Models\Plugins\Announcement::fromWebsite(website())
                ->orderBy('id', 'desc')
                ->paginate(10);
        });
    }
}
