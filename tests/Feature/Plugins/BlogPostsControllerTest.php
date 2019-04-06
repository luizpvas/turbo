<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostsControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->enablePlugin('App\Plugins\Blog');
    }

    function test_lists_all_blog_posts()
    {
        $published = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $unpublished = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id,
            'published_at' => null
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.blog_posts.index', $this->website))
            ->assertSee(e($published->title))
            ->assertSee(e($unpublished->title));
    }

    function test_filters_blog_posts_by_title()
    {
        $post1 = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $post2 = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.blog_posts.index', [$this->website, 'q' => $post1->title]))
            ->assertSee(e($post1->title))
            ->assertDontSee(e($post2->title));
    }

    function test_renders_new_blog_post_form()
    {
        $this->actingAs($this->website->owner)
            ->get(route('websites.blog_posts.create', $this->website))
            ->assertStatus(200);
    }

    function test_validates_title_and_body_on_store()
    {
        $this->actingAs($this->website->owner)
            ->postJson(route('websites.blog_posts.store', $this->website), [
                 'title'     => '',
                 'body_html' => '',
                 'body_text' => ''
            ])
            ->assertJsonValidationErrors(['title', 'body_html', 'body_text']);
    }

    function test_stores_a_new_blog_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->website->owner)
            ->postJson(route('websites.blog_posts.store', $this->website), [
                 'title'     => 'Grass city',
                 'body_html' => '<div>Cool cat</div>',
                 'body_text' => 'Cool cat'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('plugins_blog_posts', [
            'website_id' => $this->website->id,
            'author_id' => $this->website->owner->id,
            'title' => 'Grass city'
        ]);
    }

    function test_renders_edit_blog_post_form()
    {
        $post = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.blog_posts.edit', [$this->website, $post]))
            ->assertStatus(200);
    }

    function test_validates_title_and_body_on_update()
    {
        $post = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->putJson(route('websites.blog_posts.update', [$this->website, $post]), [
                 'title'     => '',
                 'body_html' => '',
                 'body_text' => ''
            ])
            ->assertJsonValidationErrors(['title', 'body_html', 'body_text']);
    }

    function test_updates_blog_post()
    {
        $post = factory('App\Models\Plugins\BlogPost')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->putJson(route('websites.blog_posts.update', [$this->website, $post]), [
                 'title' => 'Updated title'
            ])
            ->assertStatus(200);

        $this->assertEquals('Updated title', $post->fresh()->title);
    }


    function test_doesnt_allow_if_not_authenticated()
    {
        $this->get(route('websites.blog_posts.index', $this->website))
            ->assertRedirect(route('login'));
    }

    function test_doesnt_allow_if_not_authorized()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->get(route('websites.blog_posts.index', $this->website))
            ->assertStatus(403);
    }

    function test_doesnt_allow_if_plugin_not_enabled()
    {
        $this->website->disablePlugin('App\Plugins\Blog');

        $this->actingAs($this->website->owner)
            ->get(route('websites.blog_posts.index', $this->website))
            ->assertStatus(403);
    }
}
