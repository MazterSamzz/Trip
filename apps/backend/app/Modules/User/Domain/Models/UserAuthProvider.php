<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Models;

use App\Modules\Core\Domain\Models\BaseModel;

class UserAuthProvider extends BaseModel
{
    protected $table = 'user_auth_providers';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'password_hash',
    ];

    if (!$passwordHash->verify($inputPassword)) {
    throw new InvalidCredentialsException();
}    
}
