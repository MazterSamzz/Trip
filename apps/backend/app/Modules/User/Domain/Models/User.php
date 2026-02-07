<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Models;

use App\Modules\Core\Domain\Models\BaseModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function username(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower($value)
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower($value)
        );
    }

    public function authProviders()
    {
        return $this->hasMany(UserAuthProvider::class);
    }
}
