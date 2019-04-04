<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    function test_a_website_has_a_unique_domain()
    {
        $this->expectException(\PDOException::class);

        $website = factory('App\Models\Website')->create();

        factory('App\Models\Website')->create([
            'domain' => $website->domain
        ]);
    }

    function test_a_website_has_a_unique_subdomain()
    {
        $this->expectException(\PDOException::class);

        $website = factory('App\Models\Website')->create();

        factory('App\Models\Website')->create([
            'subdomain' => $website->subdomain
        ]);
    }

    function test_generates_a_url_for_a_website()
    {
    }

    function test_find_by_host()
    {
        $website = factory('App\Models\Website')->create([
            'domain' => 'teclia.com',
            'subdomain' => 'teclia'
        ]);

        $this->assertNotNull(Website::findByHost('teclia.turbo.app'));
        $this->assertNotNull(Website::findByHost('teclia.com'));
        $this->assertNull(Website::findByHost('teclia.otherdomain.com'));
    }
}
