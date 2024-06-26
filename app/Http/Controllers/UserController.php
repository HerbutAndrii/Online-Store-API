<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index() {
        $users = Cache::remember('users', 60, function () {
            return User::with('products')->orderByDesc('updated_at')->get();
        });

        return UserResource::collection($users);
    }

    public function show(User $user) {
        return new UserResource($user->load('products'));
    }

    public function destroy(User $user) {
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'User was deleted successfully']);
    }
}
