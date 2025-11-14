<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
