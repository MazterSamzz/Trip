<?php

declare(strict_types=1);

namespace App\Modules\User\Application\Services;

use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Models\UserAuthProvider;

class OAuthUserService
{
    // 
    public function execute(
        string $provider,
        string $providerId,
        string $email,
        string $name
    ): User {

        // Check if user with the given email already exists
        $user = User::where('email', $email)->first();

        // If user exists create new user
        if (!$user) {
            $user = User::create([
                'email'    => $email,
                'username' => $this->generateUsername($name),
                'password' => null,
                'name'     => $name,
            ]);
        }

        // Attach provider info to user
        $this->attachProvider($user, $provider, $providerId);
        return $user;
    }

    private function attachProvider(
        User $user,
        string $provider,
        string $providerId
    ): void {
        UserAuthProvider::firstOrCreate(
            [
                'user_id'  => $user->id,
                'provider' => $provider,
                'provider_id' => $providerId,
            ]
        );
    }


    private function generateUsername(string $name): string
    {
        do {
            $username = strtolower(str_replace(' ', '_', $name)) . rand(01, 99);
        } while (User::where('username', $username)->exists());

        return $username;
    }
}
