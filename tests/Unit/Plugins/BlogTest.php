<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use App\Models\Plugins\BlogPostTag;
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

        $this->post1 = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id,
            'title' => 'Grass city',
        ]);

        $this->post2 = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);
    }

    function test_renders_post_title()
    {
        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee($this->post1->title);
    }

    function test_renders_post_body()
    {
        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee($this->post1->body_html);
    }

    function test_renders_post_tags()
    {
        BlogPostTag::sync($this->post1, ['Blue tag']);


        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee('Blue tag');
    }

    function test_renders_post_author()
    {
        $this->withoutExceptionHandling();

        $this->get($this->website->route('/blog/post/grass-city'))
            ->assertSee(e($this->post1->author->name));
    }

    function test_renders_paginated_blog_items()
    {
        $this->get($this->website->route('/blog/index'))
            ->assertSee($this->post1->title)
            ->assertSee($this->post2->title);
    }

    function test_renders_blog_item_url()
    {
        $this->get($this->website->route('/blog/index'))
            ->assertSee('/blog/post/' . $this->post1->slug)
            ->assertSee('/blog/post/' . $this->post2->slug);
    }

    function test_renders_post_tags_on_index()
    {
        BlogPostTag::sync($this->post1, ['Tag1', 'Tag2']);

        $this->get($this->website->route('/blog/index'))
            ->assertSee('Tag1')
            ->assertSee('Tag2');
    }

    function test_renders_post_author_on_index()
    {
        $this->get($this->website->route('/blog/index'))
            ->assertSee(e($this->post1->author->name))
            ->assertSee(e($this->post2->author->name));
    }

    function test_renders_post_related()
    {
    }
}
