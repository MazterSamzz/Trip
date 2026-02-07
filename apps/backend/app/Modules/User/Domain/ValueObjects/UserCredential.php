<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

class UserCredential
{
    public function __construct(
        public string $login, // username atau email
        public string $password
    ) {
        // Logic
    }
}
