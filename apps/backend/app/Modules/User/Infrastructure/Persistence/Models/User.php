<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence\Models;

use App\Modules\Core\Domain\Models\BaseAuthenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseAuthenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    // -- UUID configuration --
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'username',
        'email',
        'name',
    ];

    protected $hidden = [
        'remember_token',
    ];

    // -- Relationships --
    public function authProviders(): HasMany
    {
        return $this->hasMany(
            UserAuthProvider::class,
            'user_id'
        );
    }
}
