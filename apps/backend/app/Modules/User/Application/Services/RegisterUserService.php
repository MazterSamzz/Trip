<?php

declare(strict_types=1);

namespace App\Modules\User\Application\Services;

use App\Modules\User\Application\Data\RegisterUserData;
use App\Modules\User\Domain\Models\User;
use DomainException;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;
use App\Modules\User\Domain\ValueObjects\PasswordHash;

class RegisterUserService
{
    public function __construct(
        private UserRepository $users
    ) {}

    // Re gister a new user
    public function execute(RegisterUserData $data): User
    {
        $email = Email::fromString($data->email);
        $username = Username::fromString($data->username);

        // Check for duplicate email
        if ($this->users->existsByEmail($email)) {
            throw new DomainException('Email already exists');
        }

        // Check for duplicate username
        if ($this->users->existsByUsername($username)) {
            throw new DomainException('Username already exists');
        }

        $user = User::register(
            UserId::generate(),
            $username,
            $email,
            PasswordHash::fromPlain($data->password)
        );

        return $this->users->save($user);
    }
}
