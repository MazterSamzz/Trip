<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repositories;

use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Domain\ValueObjects\Email;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;

final class EloquentUserRepository implements UserRepository
{
    // Create a new user
    public function save(User $user): User
    {
        $user->save();
        return $user;
    }

    //Find a user by ID
    public function find(UserId $id): ?User
    {
        return User::find($id->value());
    }

    // Find a user by email
    public function findByEmail(Email $email): ?User
    {
        return User::where('email', $email->value())->first();
    }

    // Check if a user exists by email
    public function existsByEmail(Email $email): bool
    {
        return User::where('email', $email->value())->exists();
    }
    // Check if a user exists by username
    public function existsByUsername(Username $username): bool
    {
        return User::where('username', $username->value())->exists();
    }
}
