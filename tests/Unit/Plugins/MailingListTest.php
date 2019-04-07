<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailingListTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_mailing_list_form()
    {
        $website = factory('App\Models\Website')->create();
        $website->publishTemplatesFromDirectory('tests/fixtures/teclia.com');

        $this->get($website->route('/mailing_list'))
            ->assertSee('<form data-controller="mailing-list"');
    }
}
