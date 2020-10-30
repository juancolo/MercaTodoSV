<?php

namespace Tests\Feature\Store\Payment;

use Tests\TestCase;

class EndTransactionTest extends TestCase
{
    /**
     * @test
    */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
