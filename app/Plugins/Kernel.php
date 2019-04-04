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