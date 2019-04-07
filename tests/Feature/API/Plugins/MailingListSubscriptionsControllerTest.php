<?php

namespace Tests\Feature\API\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailingListSubscriptionsControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->mailingList = factory('App\Models\Plugins\MailingList')->create();
    }

    function test_validates_email_format()
    {
        $this->postJson(route('api.mailing_list_subscriptions.store'), [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz'
        ])->assertJsonValidationErrors(['email']);
    }

    function test_creates_a_new_subscription()
    {
        $this->postJson(route('api.mailing_list_subscriptions.store'), [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com'
        ])->assertStatus(200);

        $this->assertDatabaseHas('plugins_mailing_list_subscriptions', [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com'
        ]);
    }

    function test_stores_additional_attributes()
    {
        $this->postJson(route('api.mailing_list_subscriptions.store'), [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com',
            'name' => 'Luiz Paulo'
        ])->assertStatus(200);

        $this->assertDatabaseHas('plugins_mailing_list_subscriptions', [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com',
            'attrs' => json_encode(['name' => 'Luiz Paulo'])
        ]);
    }

    function test_doesnt_subscribe_the_same_email_twice()
    {
        $this->postJson(route('api.mailing_list_subscriptions.store'), [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com'
        ])->assertSee($this->mailingList->subscribed_success_template);

        $this->postJson(route('api.mailing_list_subscriptions.store'), [
            'mailing_list_id' => $this->mailingList->id,
            'email' => 'luiz@teclia.com',
        ])->assertSee($this->mailingList->already_subscribed_template);
    }
}
