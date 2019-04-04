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

        $website->enablePlugin('Blog');

        $this->assertCount(1, $website->enabledPlugins);
    }

    function test_disables_a_plugin()
    {
        $website = factory('App\Models\Website')->create();

        $website->enablePlugin('Blog');
        $website->disablePlugin('Blog');

        $this->assertCount(0, $website->enabledPlugins);
    }
}
