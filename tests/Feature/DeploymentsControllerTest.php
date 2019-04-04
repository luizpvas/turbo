<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeploymentsControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();

        $this->website = factory('App\Models\Website')->create();

        copy(base_path('tests/fixtures/teclia.com.zip'), base_path('tests/fixtures/cp-teclia.com.zip'));
        $this->file = base_path('tests/fixtures/cp-teclia.com.zip');
    }

    function test_updates_the_website_templates_version()
    {
        $this->withoutExceptionHandling();

        $currentVersion = $this->website->templates_version;

        $this->post(route('deployments.store'), [
            'key' => $this->website->private_key,
            'file' => new UploadedFile($this->file, 'teclia.com.zip', 'application/zip', filesize($this->file), null, true)
        ])
            ->assertStatus(201);

        $this->assertNotEquals($currentVersion, $this->website->fresh()->templates_version);
    }

    function test_creates_a_new_deployment_record()
    {
        $json = $this->post(route('deployments.store'), [
            'key' => $this->website->private_key,
            'file' => new UploadedFile($this->file, 'teclia.com.zip', 'application/zip', filesize($this->file), null, true)
        ])
            ->assertStatus(201)
            ->json();

        $this->assertDatabaseHas('deployments', [
            'website_id' => $this->website->id,
            'templates_version' => $json['templates_version']
        ]);
    }

    function test_identifies_templates_inside_zip_directory()
    {
        $json = $this->post(route('deployments.store'), [
            'key' => $this->website->private_key,
            'file' => new UploadedFile($this->file, 'teclia.com.zip', 'application/zip', filesize($this->file), null, true)
        ])
            ->assertStatus(201)
            ->json();

        $this->assertDatabaseHas('templates', [
            'website_id' => $this->website->id,
            'path' => '/page.html',
            'version' => $json['templates_version']
        ]);
    }
}
