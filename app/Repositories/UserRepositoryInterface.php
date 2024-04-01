<?php

namespace App\Repositories;

use App\Models\Domain\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByName(string $name): ?User;
    public function findByEmail(string $email): ?User;
}
