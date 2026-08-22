<?php

namespace Tests\Feature;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_responses_include_baseline_security_headers(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), geolocation=(), microphone=()')
            ->assertHeader(
                'Content-Security-Policy',
                "base-uri 'self'; object-src 'none'; frame-ancestors 'none'; form-action 'self'",
            );
    }

    public function test_hsts_is_added_only_for_secure_production_requests(): void
    {
        config()->set('app.env', 'production');
        $request = Request::create('https://rizkimobil.com/', 'GET');

        $response = (new SecurityHeaders)->handle($request, fn () => response('OK'));

        $this->assertSame('max-age=31536000', $response->headers->get('Strict-Transport-Security'));
    }

    public function test_login_is_rate_limited_after_repeated_failures(): void
    {
        $payload = [
            'email' => 'rate-limit@example.com',
            'password' => 'invalid-password',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', $payload)->assertSessionHasErrors('email');
        }

        $this->post('/login', $payload)->assertTooManyRequests();
    }

    public function test_contact_form_is_rate_limited(): void
    {
        $payload = [
            'name' => 'Security Test',
            'email' => 'security@example.com',
            'phone' => '081234567890',
            'message' => 'Permintaan informasi unit.',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/contact', $payload)->assertRedirect();
        }

        $this->post('/contact', $payload)->assertTooManyRequests();
        $this->assertDatabaseCount('contacts', 5);
    }

    public function test_contact_database_errors_do_not_log_customer_data(): void
    {
        Log::spy();
        Schema::drop('contacts');

        $sentinel = 'never-log-this-customer-data';

        $this->post('/contact', [
            'name' => $sentinel,
            'email' => $sentinel.'@example.com',
            'phone' => '081234567890',
            'message' => $sentinel,
        ])->assertSessionHas('error');

        Log::shouldHaveReceived('error')
            ->once()
            ->withArgs(function (string $message, array $context) use ($sentinel): bool {
                $loggedData = $message.json_encode($context);

                return $message === 'Contact form submission failed.'
                    && ! str_contains($loggedData, $sentinel);
            });
    }

    public function test_upload_directory_denies_script_execution_on_apache(): void
    {
        $rules = file_get_contents(public_path('images/cars/.htaccess'));

        $this->assertStringContainsString('Options -Indexes', $rules);
        $this->assertStringContainsString('php[0-9]?', $rules);
        $this->assertStringContainsString('Require all denied', $rules);
    }

    public function test_public_web_root_blocks_indexes_and_common_sensitive_archives_on_apache(): void
    {
        $rules = file_get_contents(public_path('.htaccess'));

        $this->assertStringContainsString('Options -Indexes', $rules);
        $this->assertStringContainsString('sql|sqlite|sqlite3|tar|tgz|zip', $rules);
        $this->assertStringContainsString('Require all denied', $rules);
    }
}
