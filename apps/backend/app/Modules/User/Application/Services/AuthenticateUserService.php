<?php

declare(strict_types=1);

namespace App\Modules\User\Application\Services;

use App\Modules\User\Domain\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateUserService extends \App\Modules\Core\Application\Services\BaseService
{
    public function execute(string $login, string $password): ?User
    {
        // Get User by username or email
        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        if (!$user) {
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }
}
