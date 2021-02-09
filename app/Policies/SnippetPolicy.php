<?php

namespace App\Policies;

use App\Models\Snippet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
    use HandlesAuthorization;

    public function show(?User $user, Snippet $snippet)
    {
        /**
         * for some reason User doesn't work if guard auth is default to 'web'. It needed to change to
         * 'sanctum' in order to work. In fact, we can only access user via 'sanctum' guard.
         */
        if ($snippet->isPublic()) return true;

        return $user?->id === $snippet->user_id;
    }

    public function update(?User $user, Snippet $snippet)
    {
        return $user?->id === $snippet->user_id ? $this->allow() : $this->deny('you do not own this snippet');
    }

    public function destroy(User $user, Snippet $snippet)
    {
        return $user->id === $snippet->user_id;
    }
}
