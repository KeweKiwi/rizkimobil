<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_account_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Rizki Buyer',
            'email' => 'buyer@example.com',
            'phone' => '081234567890',
        ]);

        $this->actingAs($user)
            ->get(route('account.show'))
            ->assertOk()
            ->assertSee('Rizki Buyer')
            ->assertSee('buyer@example.com')
            ->assertSee('081234567890')
            ->assertSee('Informasi profil')
            ->assertSee('Keamanan');
    }

    public function test_user_can_update_profile_information(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'phone' => '081111111111',
            'password' => 'password123',
        ]);

        $this->actingAs($user)
            ->from(route('account.show'))
            ->put(route('account.profile.update'), [
                'name' => 'New Name',
                'email' => 'new@example.com',
                'phone' => '082222222222',
                'current_password' => 'password123',
            ])
            ->assertRedirect(route('account.show'))
            ->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertSame('082222222222', $user->phone);
    }

    public function test_email_change_requires_the_current_password(): void
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'password' => 'password123',
        ]);

        $this->actingAs($user)
            ->from(route('account.show'))
            ->put(route('account.profile.update'), [
                'name' => $user->name,
                'email' => 'new@example.com',
                'phone' => $user->phone,
            ])
            ->assertRedirect(route('account.show'))
            ->assertSessionHasErrors('current_password');

        $this->assertSame('old@example.com', $user->fresh()->email);
    }

    public function test_profile_update_requires_valid_unique_contact_information(): void
    {
        User::factory()->create([
            'email' => 'taken@example.com',
        ]);

        $user = User::factory()->create([
            'email' => 'buyer@example.com',
            'phone' => '081234567890',
        ]);

        $this->actingAs($user)
            ->from(route('account.show'))
            ->put(route('account.profile.update'), [
                'name' => '',
                'email' => 'taken@example.com',
                'phone' => '123',
            ])
            ->assertRedirect(route('account.show'))
            ->assertSessionHasErrors(['name', 'email', 'phone']);
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
            'remember_token' => 'old-remember-token',
        ]);

        $this->actingAs($user)
            ->from(route('account.show'))
            ->put(route('account.password.update'), [
                'current_password' => 'password123',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ])
            ->assertRedirect(route('account.show'))
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        $this->assertNotSame('old-remember-token', $user->fresh()->remember_token);
    }

    public function test_password_change_invalidates_a_session_with_the_old_password_hash(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);
        $oldPasswordHash = $user->password;

        $user->update(['password' => 'newpassword123']);

        $this->actingAs($user)
            ->withSession(['password_hash_web' => $oldPasswordHash])
            ->get(route('account.show'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_password_change_requires_current_password_and_minimum_length(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $this->actingAs($user)
            ->from(route('account.show'))
            ->put(route('account.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'short',
                'password_confirmation' => 'short',
            ])
            ->assertRedirect(route('account.show'))
            ->assertSessionHasErrors(['current_password', 'password']);
    }
}
