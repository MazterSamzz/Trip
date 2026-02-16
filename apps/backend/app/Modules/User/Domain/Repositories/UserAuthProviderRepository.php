<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Repositories;

use App\Modules\User\Domain\Entities\UserAuthProvider as Provider;
use App\Modules\User\Domain\ValueObjects\UserId;

interface UserAuthProviderRepositoryInterface
{
    public function save(Provider $authProvider): void;

    public function findByProviderId(
        string $authProvider,
        string $authProviderId
    ): ?Provider;

    public function findByUserId(
        string $authProvider,
        UserId $userId
    ): ?Provider;
}
