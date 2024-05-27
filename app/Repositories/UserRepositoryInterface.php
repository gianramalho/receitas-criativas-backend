<?php

namespace App\Repositories;

use App\Models\Domain\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByName(string $name): ?User;
    public function findByEmail(string $email): ?User;
    public function store(array $data): ?User;
    public function deleteAllTokens(User $user): ?User;
    public function createToken(User $user): String;
}
