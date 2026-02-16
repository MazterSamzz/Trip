<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Entities;

use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Password;
use Ramsey\Uuid\Uuid;

class UserAuthProvider
{
    private function __construct(
        private string $id,
        private UserId $userId,
        private string $provider,
        private ?Password $password = null,
        private ?string $providerId = null,
    ) {}

    public static function createLocal(UserId $userId, Password $password,): self
    {
        return new self(
            Uuid::uuid7()->toString(),
            $userId,
            'local',
            $password
        );
    }

    public static function createOAuth(
        UserId $userId,
        string $provider,
        string $providerId,
    ): self {
        return new self(
            Uuid::uuid7()->toString(),
            $userId,
            $provider,
            null,
            $providerId
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function provider(): string
    {
        return $this->provider;
    }

    public function providerId(): string
    {
        return $this->providerId;
    }

    public function password(): ?Password
    {
        return $this->password;
    }
}
