<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');
        $this->website->enablePlugin('App\Plugins\Blog');

        $this->post = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id,
            'title' => 'Grass city',
        ]);
    }

    function test_renders_post_title()
    {
        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee($this->post->title);
    }

    function test_renders_post_body()
    {
        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee($this->post->body_html);
    }

    function test_renders_post_tags()
    {
    }

    function test_renders_post_related()
    {
    }
}
