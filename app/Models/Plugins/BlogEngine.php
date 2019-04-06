<?php

namespace App\Models\Plugins;

use Illuminate\Database\Eloquent\Model;

class BlogEngine extends Model
{
    /**
     * Prevent mass assignment exceptions.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the default engine for the given website.
     *
     * @param  App\Models\Website $website Current website
     * @return BlogEngine|null
     */
    static function defaultForWebsite($website)
    {
        return self::where('website_id', $website->id)->first();
    }
}
