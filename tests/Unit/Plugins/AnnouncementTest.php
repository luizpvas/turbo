<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    function test_belongs_to_a_website()
    {
        $announcement = factory('App\Models\Plugins\Announcement')->create();

        $this->assertNotNull($announcement->website);
    }

    function test_marks_a_single_announcement_as_highlighted()
    {
        $website = factory('App\Models\Website')->create();

        $announcement1 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id,
            'is_highlighted' => true
        ]);

        $announcement2 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id
        ]);

        $announcement2->update(['is_highlighted' => true]);

        $this->assertFalse($announcement1->fresh()->is_highlighted);
    }

    function test_renders_highlighted_title()
    {
        $this->withoutExceptionHandling();

        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id,
            'is_highlighted' => true
        ]);

        $this->get($website->route('/page_with_announcement'))
            ->assertSee(e($announcement->title));
    }

    function test_renders_highlighted_body()
    {
        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $announcement = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id,
            'is_highlighted' => true
        ]);

        $this->get($website->route('/page_with_announcement'))
            ->assertSee($announcement->body);
    }

    function test_doesnt_render_highlighted_announcement_if_it_doesnt_exist()
    {
        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $this->get($website->route('/page_with_announcement'))
            ->assertDontSee('<div>Announcement</div>');
    }

    function test_throws_an_exception_if_closing_block_not_found()
    {
        $this->withoutExceptionHandling();
        $this->expectException(\App\Exceptions\CallNotFoundException::class);

        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $this->get($website->route('/page_with_invalid_announcement'))
            ->assertStatus(500);
    }

    function test_renders_announcements_in_a_list()
    {
        $this->withoutExceptionHandling();

        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $announcement1 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id,
        ]);

        $announcement2 = factory('App\Models\Plugins\Announcement')->create([
            'website_id' => $website->id
        ]);

        $this->get($website->route('/latest_announcements'))
            ->assertStatus(200)
            ->assertSee($announcement1->title)
            ->assertSee($announcement1->body)
            ->assertSee($announcement2->title)
            ->assertSee($announcement2->body);
    }
}
