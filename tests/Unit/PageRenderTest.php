<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageRenderTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');
    }

    function test_renders_a_template_with_a_layout()
    {
        $this->assertEquals(
            "<div>Layout</div>\n\n\n<div>Page</div>\n\n",
            $this->website->renderTemplate('page')
        );
    }

    function test_renders_a_template_with_include()
    {
        $this->assertEquals(
            "<div>Page</div>\n<div>Widget</div>\n\n",
            $this->website->renderTemplate('page_with_widget')
        );
    }
}
