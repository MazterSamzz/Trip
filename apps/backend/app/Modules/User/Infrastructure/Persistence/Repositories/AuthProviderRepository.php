<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence\Repositories;

use App\Modules\User\Domain\Entities\UserAuthProvider as DomainUserAuthProvider;
use App\Modules\User\Infrastructure\Persistence\Models\UserAuthProvider;
use App\Modules\User\Domain\Repositories\UserAuthProviderRepositoryInterface;
use App\Modules\User\Domain\ValueObjects\UserId;

class UserAuthProviderRepository implements UserAuthProviderRepositoryInterface
{
    public function save(DomainUserAuthProvider $authProvider): void
    {
        UserAuthProvider::updateOrCreate(
            ['id' => $authProvider->id()],
            [
                'user_id' => $authProvider->userId()->value(),
                'provider' => $authProvider->provider(),
                'provider_user_id' => $authProvider->providerId(),
                'password' => $authProvider->password()?->value(),
            ]
        );
    }

    public function findByProviderId(string $provider, string $providerId): ?DomainUserAuthProvider
    {
        $model = UserAuthProvider::where('provider_id', $providerId)
            ->where('provider', $provider)
            ->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function findByUserId(string $provider, UserId $userId): ?DomainUserAuthProvider
    {
        $model = UserAuthProvider::where('user_id', $userId->value())
            ->where('provider', $provider)
            ->first();

        return $model ? $this->toDomain($model) : null;
    }

    // Convert Eloquent model to domain entity
    private function toDomain(UserAuthProvider $model): DomainUserAuthProvider
    {
        return $model->provider_user_id
            ? DomainUserAuthProvider::createOAuth(
                UserId::fromString($model->user_id),
                $model->provider,
                $model->provider_user_id
            )
            : DomainUserAuthProvider::createLocal(
                UserId::fromString($model->user_id),
                \App\Modules\User\Domain\ValueObjects\Password::fromHash($model->password)
            );
    }
}
