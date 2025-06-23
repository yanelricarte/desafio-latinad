<?php

namespace App\Policies;

use App\Models\Display;
use App\Models\User;

class DisplayPolicy
{
    public function view(User $user, Display $display): bool
    {
        return $user->id === $display->user_id;
    }

    public function update(User $user, Display $display): bool
    {
        return $user->id === $display->user_id;
    }

    public function delete(User $user, Display $display): bool
    {
        return $user->id === $display->user_id;
    }
}
