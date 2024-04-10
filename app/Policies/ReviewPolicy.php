<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function before(User $user) {
        if($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function update(User $user, Review $review) {
        return $user->id === $review->user->id;
    }

    public function delete(User $user, Review $review) {
        return $user->id === $review->user->id;
    }
}
