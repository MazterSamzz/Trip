<?php

declare(strict_types=1);

namespace App\Modules\User\Application\Services;

use App\Modules\User\Domain\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserService
{
    // Register a new user
    public function execute(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }
}
