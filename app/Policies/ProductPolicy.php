<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function before(User $user) {
        if($user->isAdmin()) {
            return true;
        }

        return null;
    }
    
    public function update(User $user, Product $product) {
        return $user->id === $product->user->id;
    }

    public function delete(User $user, Product $product) {
        return $user->id === $product->user->id;
    }
}
