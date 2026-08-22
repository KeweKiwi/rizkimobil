<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_does_not_create_or_promote_a_default_administrator(): void
    {
        $user = User::factory()->create([
            'email' => 'legacy-admin-sentinel@example.test',
            'is_admin' => false,
        ]);

        $this->seed();

        $this->assertFalse($user->fresh()->isAdmin());
    }
}
