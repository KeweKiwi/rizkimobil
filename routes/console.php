<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:admin {email} {--revoke : Remove admin access from the user}', function (string $email): int {
    $user = User::where('email', $email)->first();

    if (!$user) {
        $this->error("User with email {$email} was not found.");

        return 1;
    }

    $user->forceFill([
        'is_admin' => !$this->option('revoke'),
    ])->save();

    $state = $user->is_admin ? 'granted' : 'revoked';
    $this->info("Admin access {$state} for {$user->email}.");

    return 0;
})->purpose('Grant or revoke admin panel access for an existing user');
