<?php

namespace PavelZanek\RedirectionsLaravel\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectionsToolTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_redirects_list()
    {
        $response = $this->get(route('redirects.index'));
        $response->assertStatus(200);
    }
}