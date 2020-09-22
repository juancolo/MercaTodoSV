<?php

namespace Tests\Feature\Admin\Product\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Langind extends TestCase
{
    /**
     * @test
     */
    public function Example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
