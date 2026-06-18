<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_search_make_options_include_mini(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Mini');
    }

    public function test_homepage_header_shows_brand_promise_under_logo(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Jual Beli Mobil Bekas Berkualitas');
        $response->assertSee('CASH DAN KREDIT');
        $response->assertSee('Bisa Proses seluruh Wilayah Indonesia');
    }
}
