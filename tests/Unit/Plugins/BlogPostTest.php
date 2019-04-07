<?php

namespace Tests\Unit\Plugins;

use Tests\TestCase;
use App\Models\Plugins\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    function test_slug_generation()
    {
        $this->assertEquals(
            'hello-world',
            BlogPost::generateSlug('Hello world')
        );

        $this->assertEquals(
            'hello-world',
            BlogPost::generateSlug('Hello, world?')
        );

        $this->assertEquals(
            'coracao',
            BlogPost::generateSlug('coração')
        );

        $this->assertEquals(
            'opcao-azul',
            BlogPost::generateSlug('opcao/azul')
        );
    }
}
