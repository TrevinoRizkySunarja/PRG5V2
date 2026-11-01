<?php

use App\Models\LoginDay;
use App\Models\User;

it('records a successful login once per calendar day and never records failed attempts', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->post(route('login'), ['email' => $user->email, 'password' => 'wrong-password']);
    $this->assertDatabaseCount('login_days', 0);

    $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
    $this->assertDatabaseCount('login_days', 1);

    $this->post(route('logout'));
    $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
    $this->assertDatabaseCount('login_days', 1);
    expect(LoginDay::firstOrFail()->user_id)->toBe($user->id);
});
