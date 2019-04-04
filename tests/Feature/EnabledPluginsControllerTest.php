<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnabledPluginsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_enables_a_plugin_in_the_website()
    {
        $website = factory('App\Models\Website')->create();

        $this->actingAs($website->owner)
            ->postJson(route('websites.enabled_plugins.store', [
                $website,
                'plugin_class' => 'App\Plugins\Blog'
            ]))
            ->assertStatus(200);

        $this->assertTrue($website->hasPlugin('App\Plugins\Blog'));
    }

    function test_disables_a_plugin_from_website()
    {
        $this->withoutExceptionHandling();

        $website = factory('App\Models\Website')->create();
        $plugin = $website->enablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->deleteJson(route('websites.enabled_plugins.destroy', [$website, $plugin]))
            ->assertStatus(200);

        $this->assertFalse($website->hasPlugin('App\Plugins\Blog'));
    }
}
