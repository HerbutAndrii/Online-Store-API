<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function before(User $user) {
        if($user->isAdmin()) {
            return true;
        }

        return null;
    }
    
    public function update(User $user, Company $company) {
        return $user->id === $company->user->id;
    }

    public function delete(User $user, Company $company) {
        return $user->id === $company->user->id;
    }
}
