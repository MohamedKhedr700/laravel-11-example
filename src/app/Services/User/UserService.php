<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        private readonly User $user,
    ) {
        
    }

    public function list(): Collection
    {
        return $this->user->query()->get();
    }

    public function create(array $data): User
    {
        return $this-user->create($data);
    }
}