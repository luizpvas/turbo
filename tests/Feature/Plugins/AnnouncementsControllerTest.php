<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnouncementsControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->enablePlugin('App\Plugins\Announcement');
    }

    function test_lists_existing_annoucements()
    {
        $announcement1 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id,
            'is_highlighted' => true
        ]);

        $announcement2 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.announcements.index', $this->website))
            ->assertSee($announcement1->title)
            ->assertSee($announcement2->title);
    }

    function test_renders_new_announcement_form()
    {
        $this->actingAs($this->website->owner)
            ->get(route('websites.announcements.create', $this->website))
            ->assertStatus(200);
    }

    function test_validates_attributes_on_create()
    {
        $this->actingAs($this->website->owner)
            ->postJson(route('websites.announcements.store', $this->website), [
                 'title'     => '',
                 'body_html' => '',
                 'body_text' => ''
            ])
            ->assertJsonValidationErrors(['title', 'body_html', 'body_text']);
    }

    function test_creates_new_announcement()
    {
        $this->actingAs($this->website->owner)
            ->postJson(route('websites.announcements.store', $this->website), [
                 'title'     => 'My title',
                 'body_html' => '<div>My body</div>',
                 'body_text' => 'My body'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('plugins_announcements', [
            'website_id' => $this->website->id,
            'author_id'  => $this->website->owner->id,
            'title'      => 'My title',
            'body_html'  => '<div>My body</div>',
            'body_text'  => 'My body'
        ]);
    }

    function test_renders_edit_announcement_form()
    {
        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.announcements.edit', [$this->website, $announcement]))
            ->assertStatus(200);
    }

    function test_validates_attributes_on_update()
    {
        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->putJson(route('websites.announcements.update', [$this->website, $announcement]), [
                 'title'     => '',
                 'body_html' => '',
                 'body_text' => ''
            ])
            ->assertJsonValidationErrors(['title', 'body_html', 'body_text']);
    }
    
    function test_updates_an_announcement()
    {
        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->putJson(route('websites.announcements.update', [$this->website, $announcement]), [
                 'title'     => 'Updated title',
                 'body_html' => '<div>Updated body</div>',
                 'body_text' => 'Updated body'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('plugins_announcements', [
            'id'         => $announcement->id,
             'title'     => 'Updated title',
             'body_html' => '<div>Updated body</div>',
             'body_text' => 'Updated body'
        ]);
    }

    function test_deletes_an_announcement()
    {
        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->deleteJson(route('websites.announcements.update', [$this->website, $announcement]))
            ->assertStatus(200);

        $this->assertTrue($announcement->fresh()->trashed());
    }

    function test_doesnt_allow_if_not_authenticated()
    {
        $this->get(route('websites.announcements.index', $this->website))
            ->assertRedirect(route('login'));
    }

    function test_doesnt_allow_if_not_authorized()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->get(route('websites.announcements.index', $this->website))
            ->assertStatus(403);
    }

    function test_doesnt_allow_if_plugin_not_enabled()
    {
        $this->website->disablePlugin('App\Plugins\Announcement');

        $this->actingAs($this->website->owner)
            ->get(route('websites.announcements.index', $this->website))
            ->assertStatus(403);
    }
}
