<?php

namespace App\Models\Traits;

use App\Models\EnabledPlugin;

trait HasPlugins
{
    /**
     * A website has many enabled plugins.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    function enabledPlugins()
    {
        return $this->hasMany(EnabledPlugin::class);
    }

    /**
     * Checks if the website has the plugin enabled.
     *
     * @param string $pluginClass Class of the plugin.
     *
     * @return boolean
     */
    function hasPlugin($pluginClass)
    {
        return $this->enabledPlugins()
            ->where('plugin_class', $pluginClass)
            ->exists();
    }


    /**
     * Enables the plugin with the associated class, if not already
     * enabled.
     *
     * @param string $pluginClass Class of the plugin.
     *
     * @return EnabledPlugin
     */
    function enablePlugin($pluginClass)
    {
        return $this->enabledPlugins()->firstOrCreate([
            'plugin_class' => $pluginClass
        ]);
    }

    /**
     * Disables the plugin from the website. The associated
     * plugin data is *not* deleted.
     *
     * @param string $pluginClass Class of the plugin.
     *
     * @return mixed
     */
    function disablePlugin($pluginClass)
    {
        return $this->enabledPlugins()
            ->where('plugin_class', $pluginClass)
            ->delete();
    }
}
