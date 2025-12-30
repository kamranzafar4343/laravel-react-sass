<?php

namespace App\Observers;
use App\Models\User;
class UserObserver
{
    public function creating(User $user)
    {
    if ($user->available_credits === null) {
    $user->available_credits = 10;
    }

    }
}
