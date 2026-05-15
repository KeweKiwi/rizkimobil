<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_is_not_admin(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Rizki Customer',
            'email' => 'customer@example.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'customer@example.com')->firstOrFail();

        $this->assertFalse($user->is_admin);
        $this->assertSame('081234567890', $user->phone);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_registration_requires_phone_and_minimum_password_length(): void
    {
        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Rizki Customer',
            'email' => 'short-password@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['phone', 'password']);
        $this->assertDatabaseMissing('users', [
            'email' => 'short-password@example.com',
        ]);
    }

    public function test_customer_can_login_and_logout(): void
    {
        User::factory()->create([
            'email' => 'customer@example.com',
            'password' => 'password123',
        ]);

        $this->post(route('login.store'), [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    }

    public function test_admin_user_can_access_admin_panel(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertOk();
    }

    public function test_user_admin_command_can_grant_and_revoke_admin_access(): void
    {
        $user = User::factory()->create([
            'email' => 'manager@example.com',
            'is_admin' => false,
        ]);

        $grantExitCode = Artisan::call('user:admin', [
            'email' => $user->email,
        ]);

        $this->assertSame(0, $grantExitCode);
        $this->assertTrue($user->fresh()->isAdmin());

        $revokeExitCode = Artisan::call('user:admin', [
            'email' => $user->email,
            '--revoke' => true,
        ]);

        $this->assertSame(0, $revokeExitCode);
        $this->assertFalse($user->fresh()->isAdmin());
    }
}
