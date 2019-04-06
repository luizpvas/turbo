<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteHasPluginsTest extends TestCase
{
    use RefreshDatabase;

    function test_enables_a_plugin()
    {
        $website = factory('App\Models\Website')->create();

        $website->enablePlugin('App\Plugins\Blog');

        $this->assertCount(1, $website->enabledPlugins);
    }

    function test_disables_a_plugin()
    {
        $website = factory('App\Models\Website')->create();

        $website->enablePlugin('App\Plugins\Blog');
        $website->disablePlugin('App\Plugins\Blog');

        $this->assertCount(0, $website->enabledPlugins);
    }
}
