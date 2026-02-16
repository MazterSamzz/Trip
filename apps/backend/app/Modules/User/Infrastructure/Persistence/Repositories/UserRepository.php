<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repositories;

use App\Modules\User\Domain\Entities\User as DomainUser;
use App\Modules\User\Infrastructure\Persistence\Models\User;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Modules\User\Domain\ValueObjects\Email;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;

final class UserRepository implements UserRepositoryInterface
{
    // Create a new user
    public function save(DomainUser $user): void
    {
        User::updateOrCreate(
            ['id' => $user->id()->value()],
            [
                'username' => $user->username()->value(),
                'email' => $user->email()->value(),
            ]
        );
    }

    // Find a user
    public function find(UserId $id): ?DomainUser
    {
        $model = User::find($id->value());
        return $model ? $this->toDomain($model) : null;
    }

    public function findByUsername(Username $username): ?DomainUser
    {
        $model = User::where('username', $username->value())->first();
        return $model ? $this->toDomain($model) : null;
    }

    public function findByEmail(Email $email): ?DomainUser
    {
        $model = User::where('email', $email->value())->first();
        return $model ? $this->toDomain($model) : null;
    }

    // Check if a user exists
    public function existsByEmail(Email $email): bool
    {
        return User::where('email', $email->value())->exists();
    }

    public function existsByUsername(Username $username): bool
    {
        return User::where('username', $username->value())->exists();
    }

    // Convert Eloquent model to domain entity
    private function toDomain(User $model): DomainUser
    {
        return DomainUser::register(
            UserId::fromString($model->id),
            Username::fromString($model->username),
            $model->email ? Email::fromString($model->email) : null
        );
    }
}
