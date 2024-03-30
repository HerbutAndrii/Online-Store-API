<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function before(User $user) {
        if($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function update(User $user, Category $category) {
        return $user->id === $category->user->id;
    }

    public function delete(User $user, Category $category) {
        return $user->id === $category->user->id;
    }
}
