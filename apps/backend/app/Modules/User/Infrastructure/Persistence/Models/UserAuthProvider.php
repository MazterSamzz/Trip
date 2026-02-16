<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence\Models;

use App\Modules\Core\Domain\Models\BaseModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAuthProvider extends BaseModel
{
    protected $table = 'user_auth_providers';

    /**
     * UUID configuration
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'password',
    ];

    // -- Relationships --
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // -- Business Logic --
    public function verifyPassword(string $plain): bool
    {
        if (!$this->password)
            return false;

        return Hash::check($plain, $this->password);
    }

    public function setPassword(string $plain): void
    {
        $this->password = Hash::make($plain);
    }
}
