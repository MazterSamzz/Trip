<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UseCases;

use App\Modules\User\Domain\Entities\User as DomainUser;
use App\Modules\User\Domain\Entities\UserAuthProvider;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;
use App\Modules\User\Domain\ValueObjects\Password;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Modules\User\Domain\Repositories\UserAuthProviderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Modules\User\Domain\Exceptions\UserAlreadyExistsException;

final class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $users,
        private UserAuthProviderRepositoryInterface $authProviders
    ) {}

    public function execute(string $username, string $email, string $password): void
    {
        DB::transaction(function () use ($username, $email, $password) {

            // 1️⃣ VO Validation
            $usernameVO = Username::fromString($username);
            $emailVO    = Email::fromString($email);
            $passwordVO = Password::make($password);

            // 2️⃣ Uniqueness Validation
            if ($this->users->existsByUsername($usernameVO)) {
                throw UserAlreadyExistsException::username($usernameVO);
            }

            if ($this->users->existsByEmail($emailVO)) {
                throw UserAlreadyExistsException::email($emailVO);
            }

            // 3️⃣ Create User entity
            $user = DomainUser::register(
                UserId::generate(),
                $usernameVO,
                $emailVO
            );

            // 4️⃣ Save User
            $this->users->save($user);

            // 5️⃣ Create AuthProvider entity
            $authProvider = UserAuthProvider::createLocal(
                $user->id(),
                $passwordVO
            );

            $this->authProviders->save($authProvider);
        });
    }
}
