<?php

namespace PavelZanek\RedirectionsLaravel\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use PavelZanek\RedirectionsLaravel\Enums\StatusCode;
use PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent;
use PavelZanek\RedirectionsLaravel\Models\Redirect;
use Tests\TestCase;

class RedirectionsToolTest extends TestCase
{
    use RefreshDatabase;

    function test_can_create_redirect()
    {
        $this->get(route('redirects.create'))->assertStatus(200);
    }

    function test_can_store_redirect()
    {
        $this->assertCount(0, Redirect::all());

        $response = $this->post(route('redirects.store'), [
            'source_url' => 'http://laravel.laratest.test:8240/redirect-test',
            'target_url' => 'http://laravel.laratest.test:8240/',
            'status_code' => StatusCode::MovedPermanently->value,
        ]);

        $this->assertCount(1, Redirect::all());

        tap(Redirect::first(), function ($redirect) use ($response) {
            $this->assertEquals('http://laravel.laratest.test:8240/redirect-test', $redirect->source_url);
            $this->assertEquals('http://laravel.laratest.test:8240/', $redirect->target_url);
            $response->assertRedirect(route('redirects.index'));
        });
    }

    function test_can_throw_validation_errors()
    {
        $this->post(route('redirects.store'), [
            'source_url' => "https://www.domain.com",
        ])
        ->assertSessionHasErrors('target_url')
        ->assertSessionHasErrors('status_code');
    }

    public function test_can_see_redirect_list()
    {
        $response = $this->get(route('redirects.index'));
        $response->assertStatus(200);
    }

    function test_can_see_redirect_detail()
    {
        $redirect = Redirect::factory()->create();
        $this->get(route('redirects.show', $redirect))
                ->assertStatus(200);
    }

    function test_can_edit_the_redirect()
    {
        $redirect = Redirect::factory()->create();
        $this->get(route('redirects.edit', $redirect))
                ->assertStatus(200);
    }

    function test_can_update_the_redirect()
    {
        $redirect = Redirect::factory()->create([
            'source_url' => "http://laravel.laratest.test:8240/redirect-test-123",
            'target_url' => "http://laravel.laratest.test:8240/redirect-test"
        ]);

        $response = $this->put(route('redirects.update', $redirect), [
            'target_url' => 'http://laravel.laratest.test:8240/',
            'status_code' => StatusCode::Found->value,
        ]);

        tap(Redirect::first(), function ($updatedRedirect) use ($response) {
            $this->assertEquals('http://laravel.laratest.test:8240/redirect-test-123', $updatedRedirect->source_url);
            $this->assertEquals('http://laravel.laratest.test:8240/', $updatedRedirect->target_url);
            $this->assertEquals(StatusCode::Found->value, $updatedRedirect->status_code->value);
            $response->assertRedirect(route('redirects.index'));
        });
    }

    // function test_event_is_emitted_when_a_new_redirect_is_created()
    // {
    //     Event::fake();

    //     $redirect = Redirect::factory()->create();
    //     $redirect->update([
    //         'last_used' => now()
    //     ]);

    //     Event::assertDispatched(RedirectWasUsedEvent::class, function ($event) use ($redirect) {
    //         return $event->redirect->id === $redirect->id;
    //     });
    // }

    function test_can_run_command()
    {
        $this->artisan('redirections:prune-database')->assertExitCode(0);
    }
}