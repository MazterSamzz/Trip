<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Repositories;

use App\Modules\User\Domain\Models\UserAuthProvider as Provider;
use App\Modules\User\Domain\ValueObjects\UserId;

interface AuthProviderRepository
{
    public function save(Provider $provider): void;

    public function findByProvider(
        string $provider,
        string $providerUserId
    ): ?Provider;

    public function findByUserAndProvider(
        UserId $userId,
        string $provider
    ): ?Provider;
}
