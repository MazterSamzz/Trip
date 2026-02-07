<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuthProvider extends Model
{
    protected $table = 'user_auth_providers';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
    ];
}
