<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use App\Models\Plugins\BlogPostTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostTagTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->post = factory('App\Models\Plugins\BlogPost')->create();
    }

    function test_creates_new_tag()
    {
        BlogPostTag::sync($this->post, ['tag1', 'tag2']);

        $this->assertEquals(['tag1', 'tag2'], $this->post->tags()->pluck('tag')->toArray());
    }

    function test_doesnt_create_tag_if_already_exists()
    {
        BlogPostTag::sync($this->post, ['tag1', 'tag2']);
        BlogPostTag::sync($this->post, ['tag1', 'tag2']);

        $this->assertEquals(['tag1', 'tag2'], $this->post->tags()->pluck('tag')->toArray());
    }

    function test_deletes_tag_from_database()
    {
        BlogPostTag::sync($this->post, ['tag1', 'tag2']);
        BlogPostTag::sync($this->post, ['tag1']);

        $this->assertEquals(['tag1'], $this->post->tags()->pluck('tag')->toArray());
    }
}
