<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Entities;

use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;

class User
{
    private function __construct(
        private UserId $id,
        private Username $username,
        private Email $email,
    ) {}

    /** Named constructor */
    public static function register(
        UserId $id,
        Username $username,
        Email $email,
    ): self {
        return new self($id, $username, $email);
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function email(): Email
    {
        return $this->email;
    }
}
