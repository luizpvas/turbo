<?php

namespace App\Plugins;

use App\Exceptions\UnknownAtCallException;

class Kernel
{
    /**
     * List of avaiable plugins.
     *
     * @var array
     */
    protected $plugins = [
        Blog::class,
        Announcement::class
    ];

    /**
     * Returns the list of available plugins.
     *
     * @return array
     */
    static function availablePlugins()
    {
        return collect((new self())->plugins)
            ->map(function ($class) {
                return new $class;
            });
    }

    /**
     * Runs the callback for enabiling the plugin.
     *
     * @param  string             $pluginClass PHP class of the plugin.
     * @param  App\Models\Website $website     Website the plugin was enabled
     * @return void
     */
    static function enable($pluginClass, $website)
    {
        $plugin = new $pluginClass;
        $plugin->enable($website);
    }

    /**
     * Attempts to run the call from the registered plugins.
     *
     * @param  mixed             $call   At call
     * @param  App\Models\Render $render Render instance
     * @return mixed
     */
    static function runCall($call, $render)
    {
        foreach (self::availablePlugins() as $plugin) {
            if ($result = $plugin->runCall($call, $render)) {
                return $result;
            }
        }

        throw new UnknownAtCallException($call);
    }
}
