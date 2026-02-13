<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Models;

use App\Modules\User\Domain\ValueObjects\PasswordHash;
use App\Modules\User\Domain\ValueObjects\UserId;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    /**
     * UUID configuration
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'username',
        'email',
        'name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid();
            }
        });
    }

    public function authProviders()
    {
        return $this->hasMany(UserAuthProvider::class);
    }

    /** Named constructor (Domain entry point) */
    public static function register(
        UserId $id,
        Username $username,
        Email $email,
        PasswordHash $passwordHash
    ): self {
        return new self([
            'id'       => $id,
            'username' => $username,
            'email'    => $email,
            'password' => $passwordHash,
        ]);
    }
}
