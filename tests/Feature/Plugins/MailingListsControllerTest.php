<?php

namespace Tests\Feature\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailingListsControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();
        $this->website->enablePlugin('App\Plugins\MailingList');
    }

    function test_lists_existing_mailing_lists()
    {
        $this->mailingList1 = factory('App\Models\Plugins\MailingList')->create([
            'website_id' => $this->website->id
        ]);

        $this->mailingList2 = factory('App\Models\Plugins\MailingList')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.mailing_lists.index', $this->website))
            ->assertSee($this->mailingList1->name)
            ->assertSee($this->mailingList2->name);
    }

    function test_renders_new_mailing_list_form()
    {
        $this->actingAs($this->website->owner)
            ->get(route('websites.mailing_lists.create', $this->website))
            ->assertStatus(200);
    }

    function test_validates_attributes_on_create()
    {
        $this->actingAs($this->website->owner)
            ->postJson(route('websites.mailing_lists.store', $this->website), [
                 'name' => ''
            ])
            ->assertJsonValidationErrors(['name']);
    }

    function test_creates_a_new_mailing_list()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->website->owner)
            ->postJson(route('websites.mailing_lists.store', $this->website), [
                 'name' => 'My mailing list'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('plugins_mailing_lists', [
            'website_id' => $this->website->id,
            'creator_id' => $this->website->owner->id,
            'name'       => 'My mailing list'
        ]);
    }

    function test_shows_mailing_list()
    {
        $this->mailingList = factory('App\Models\Plugins\MailingList')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->get(route('websites.mailing_lists.show', [$this->website, $this->mailingList]))
            ->assertStatus(200);
    }

    function test_archives_a_mailing_list()
    {
        $this->mailingList = factory('App\Models\Plugins\MailingList')->create([
            'website_id' => $this->website->id
        ]);

        $this->actingAs($this->website->owner)
            ->deleteJson(route('websites.mailing_lists.destroy', [$this->website, $this->mailingList]))
            ->assertStatus(200);

        $this->assertTrue($this->mailingList->fresh()->trashed());
    }

    function test_doesnt_allow_if_not_authenticated()
    {
        $this->get(route('websites.mailing_lists.index', $this->website))
            ->assertRedirect(route('login'));
    }

    function test_doesnt_allow_if_not_authorized()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->get(route('websites.mailing_lists.index', $this->website))
            ->assertStatus(403);
    }

    function test_doesnt_allow_if_plugin_not_enabled()
    {
        $this->website->disablePlugin('App\Plugins\MailingList');

        $this->actingAs($this->website->owner)
            ->get(route('websites.mailing_lists.index', $this->website))
            ->assertStatus(403);
    }
}
