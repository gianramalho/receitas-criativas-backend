<?php

namespace App\Application\Services;

interface UserServiceInterface
{
    public function register(array $userData);
    public function login(array $credentials);
}