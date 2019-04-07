<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteRouterTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');
    }

    function test_routes_with_html_extension()
    {
        $this->assertNotNull(
            $this->website->routeTemplate('page.html')
        );
    }

    function test_routes_no_path_to_index()
    {
        $this->assertNotNull(
            $this->website->routeTemplate('/')
        );
    }

    function test_routes_without_extension()
    {
        $this->assertNotNull(
            $this->website->routeTemplate('page')
        );
    }

    function test_routes_nested_file_directory()
    {
        $this->assertNotNull(
            $this->website->routeTemplate('/blog/post')
        );
    }

    function test_routes_with_additional_path_param()
    {
        $this->assertNotNull(
            $this->website->routeTemplate('/blog/post/some-blog-post')
        );
    }

    function test_doesnt_route_inexisting_file()
    {
        $this->expectException(\App\Exceptions\TemplateNotFoundException::class);

        $this->website->routeTemplate('/non-existing-file');
    }
}
