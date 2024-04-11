<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function before(User $user) {
        if($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function update(User $user, Tag $tag) {
        return $user->id === $tag->user->id;
    }

    public function delete(User $user, Tag $tag) {
        return $user->id === $tag->user->id;
    }
}
