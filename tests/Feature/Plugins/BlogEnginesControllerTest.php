<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use App\Models\Plugins\BlogEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogEnginesControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_edit_form()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->get(route('websites.blog_engines.edit', [$website, BlogEngine::defaultForWebsite($website)]))
            ->assertStatus(200);
    }

    function test_validates_attributes_on_update()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->putJson(route('websites.blog_engines.update', [$website, BlogEngine::defaultForWebsite($website)]), [
                 'blog_post_path' => '',
                 'posts_per_page' => 100
            ])
            ->assertJsonValidationErrors(['blog_post_path', 'posts_per_page']);
    }

    function test_updates_engine()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->putJson(route('websites.blog_engines.update', [$website, BlogEngine::defaultForWebsite($website)]), [
                 'blog_post_path' => '/blog/post',
                 'posts_per_page' => 40
            ])
            ->assertStatus(200);
    }

    function test_doesnt_allow_if_not_authenticated()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');

        $this->get(route('websites.blog_engines.edit', [$website, BlogEngine::defaultForWebsite($website)]))
            ->assertRedirect(route('login'));
    }

    function test_doesnt_allow_if_not_authorized()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->get(route('websites.blog_engines.edit', [$website, BlogEngine::defaultForWebsite($website)]))
            ->assertStatus(403);
    }

    function test_doesnt_allow_if_plugin_not_enabled()
    {
        $website = factory('App\Models\Website')->create();
        $website->enablePlugin('App\Plugins\Blog');
        $website->disablePlugin('App\Plugins\Blog');

        $this->actingAs($website->owner)
            ->get(route('websites.blog_engines.edit', [$website, BlogEngine::defaultForWebsite($website)]))
            ->assertStatus(403);
    }
}

