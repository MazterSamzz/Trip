<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Entities\User as DomainUser;
use App\Modules\User\Domain\Entities\UserAuthProvider;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Modules\User\Domain\Repositories\UserAuthProviderRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class LoginOrRegisterWithOAuth
{
    public function __construct(
        private UserRepositoryInterface $users,
        private UserAuthProviderRepositoryInterface $authProviders
    ) {}

    /**
     * @return UserId
     */
    public function execute(
        string $provider,
        string $providerUserId,
        string $email,
        string $username
    ): UserId {

        return DB::transaction(function () use (
            $provider,
            $providerUserId,
            $email,
            $username
        ): UserId {

            // 1️⃣ Already have provider? → login
            $existingProvider = $this->authProviders
                ->findByProviderId($provider, $providerUserId);

            if ($existingProvider) {
                return $existingProvider->userId();
            }

            // 2️⃣ Didn't have provider, then Check if user with same email already exists
            $emailVO = Email::fromString($email);
            $user = $this->users->findByEmail($emailVO);

            if ($user === null) {
                // 3️⃣ Didn't have user with same email, create new user
                $user = DomainUser::register(
                    UserId::generate(),
                    Username::fromString($username),
                    $emailVO
                );

                $this->users->save($user);
            }

            // 4️⃣ Create new provider for the user
            $oauthProvider = UserAuthProvider::createOAuth(
                $user->id(),
                $provider,
                $providerUserId
            );

            $this->authProviders->save($oauthProvider);

            return $user->id();
        });
    }
}
