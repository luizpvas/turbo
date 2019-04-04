<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsitesControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_lists_websites_the_user_is_owner()
    {
        $website = factory('App\Models\Website')->create();

        $this->actingAs($website->owner)
            ->get(route('websites.index'))
            ->assertSee($website->name);
    }

    function test_renders_new_website_form()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->get(route('websites.create'))
            ->assertStatus(200);
    }

    function test_validates_attributes_on_create()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->postJson(route('websites.store'), [
                 'name' => '',
                 'domain' => '',
                 'subdomain' => ''
            ])
            ->assertJsonValidationErrors(['name', 'subdomain']);
    }

    function test_creates_a_new_website()
    {
        $user = factory('App\Models\User')->create();

        $this->actingAs($user)
            ->postJson(route('websites.store'), [
                 'name' => 'Teclia',
                 'domain' => 'teclia.com',
                 'subdomain' => 'teclia'
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('websites', [
            'owner_id' => $user->id,
             'name' => 'Teclia',
             'domain' => 'teclia.com',
             'subdomain' => 'teclia'
        ]);
    }

    function test_doesnt_allow_if_not_authenticated()
    {
        $this->get(route('websites.index'))
            ->assertRedirect(route('login'));
    }
}
