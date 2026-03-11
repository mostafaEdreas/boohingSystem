<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model = User::class;

    public function createUser(array $data): ?User
    {
        return $this->model::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model::where('email', $email)->first();
    }
}
