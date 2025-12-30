<?php

use App\Models\User;

test('user credits decrease correctly', function () {
    $user = User::factory()->create(['available_credits' => 20]);

    $user->decreaseCredits(5);

    expect($user->fresh()->available_credits)->toBe(15);
});

test('credits never go below zero', function () {
    $user = User::factory()->create(['available_credits' => 2]);

    $user->decreaseCredits(10);

    expect($user->fresh()->available_credits)->toBe(0);
});
