<?php

declare(strict_types=1);

namespace App\Modules\User\Application\Data;

final class RegisterUserData
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?string $name,
    ) {}
}
