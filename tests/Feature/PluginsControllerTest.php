<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_lists_enabled_plugins()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->get(route('websites.plugins.index', $website))
            ->assertSee('Blog');
    }

    function test_renders_new_plugin_form()
    {
        $website = factory('App\Models\Website')->create();

        $this->actingAs($website->owner)
            ->get(route('websites.plugins.create', $website))
            ->assertStatus(200);
    }
}
