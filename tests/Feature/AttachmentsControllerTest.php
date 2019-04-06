<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_saves_file_to_disk()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $website = factory('App\Models\Website')->create();

        $this->actingAs($website->owner)
            ->post(route('websites.attachments.store', $website), [
                 'file' => $file
            ])
            ->assertStatus(201);

        Storage::disk('public')->assertExists('attachments/' . $file->hashName());
    }

    function test_creates_an_attachment_record()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $website = factory('App\Models\Website')->create();

        $this->actingAs($website->owner)
            ->post(route('websites.attachments.store', $website), [
                 'file' => $file
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('attachments', [
            'website_id' => $website->id,
            'user_id' => $website->owner->id,
            'name' => 'avatar.jpg',
            'size_in_bytes' => 695,
            'mime' => 'image/jpeg'
        ]);
    }
}
