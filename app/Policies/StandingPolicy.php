<?php

namespace App\Policies;

use App\Models\User;
use App\Models\standings;

class StandingPolicy
{
    public function create($user)
    {
        return $user && isset($user->role) && $user->role === 'admin';
    }

    public function update($user, standings $standing = null)
    {
        return $user && isset($user->role) && $user->role === 'admin';
    }

    public function delete($user, standings $standing = null)
    {
        return $user && isset($user->role) && $user->role === 'admin';
    }
}
