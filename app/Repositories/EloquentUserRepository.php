<?php
namespace App\Repositories;

use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        $data['email_verified_at'] = now();

        return User::create($data);
    }
}
