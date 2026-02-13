<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Stringable;

final class PasswordHash implements Stringable
{
    private function __construct(
        private string $value
    ) {}

    /**
     * Untuk password BARU dari input user
     */
    public static function fromPlain(string $plain): self
    {
        if (strlen($plain) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters.');
        }

        return new self(Hash::make($plain));
    }

    /**
     * Untuk password dari database
     */
    public static function fromHash(string $value): self
    {
        if ($value === '') {
            throw new InvalidArgumentException('Password hash cannot be empty.');
        }

        return new self($value);
    }

    public function verify(string $plain): bool
    {
        return Hash::check($plain, $this->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
