<?php

namespace App\Repositories;

use App\Models\Domain\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
        )->find($id);
    }

    public function findByName(string $name): ?User
    {
        return User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
        )->where('users.name', $name)
            ->firstOrFail();
    }

    public function findByEmail(string $email): ?User
    {
        return User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
        )->where('users.email', $email)
            ->firstOrFail();
    }

    public function deleteAllTokens(User $user): ?User
    {
        $user->tokens()->delete();

        return $user;
    }

    public function createToken(User $user): String
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function store(array $data): ?User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
