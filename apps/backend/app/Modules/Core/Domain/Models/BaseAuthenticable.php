<?php

declare(strict_types=1);

namespace App\Modules\Core\Domain\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseAuthenticatable extends Authenticatable
{
    use HasUuids;
    use SoftDeletes;

    /**
     * UUID configuration
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Default casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
