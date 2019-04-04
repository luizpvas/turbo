<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnabledPlugin extends Model
{
    /**
     * Disable mass-assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the root path of the plugin.
     *
     * @param  Website $website Current website
     * @return string
     */
    function rootPath($website)
    {
        return $this->instance()->rootPath($website);
    }

    /**
     * Returns a new instance of this plugin.
     *
     * @return mixed
     */
    function instance()
    {
        return (new $this->plugin_class);
    }
}
