<?php

namespace Http\Controllers;

use App\Http\Controllers\PostController;
use Tests\TestCase;

class PostControllerTest extends TestCase
{

    public function testStoreExpectsResource() : void
    {
        $response = $this->post('/posts', [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $response->assertSuccessful();

    }
}
